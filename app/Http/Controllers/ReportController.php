<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesReportExport;
use App\Exports\EmployeeSalesReportExport;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function salesReport(Request $request)
        {
            try {
                $salesQuery = Sale::with(['details.book']);

                if ($request->has('start_date') && $request->has('end_date')) {
                    $request->validate([
                        'start_date' => 'required|date',
                        'end_date' => 'required|date|after_or_equal:start_date',
                    ]);

                    $salesQuery->whereBetween('created_at', [$request->start_date, $request->end_date]);
                }

                $sales = $salesQuery->get();
                $totalSales = $sales->sum('total');
                $totalItemsSold = $sales->sum(function ($sale) {
                    return $sale->details->sum('quantity');
                });

                if ($request->ajax()) {
                    $html = view('reports.sales_report', compact('sales', 'totalSales', 'totalItemsSold'))->render();
                    return response()->json(['html' => $html]);
                }

                return view('reports.sales', compact('sales', 'totalSales', 'totalItemsSold'));
            } catch (\Exception $e) {
                \Log::error('Error fetching sales data: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred while fetching the data. Please try again.'], 500);
            }
}

public function exportSalesReport(Request $request)
{
    // Validate the start and end date parameters from the request
    $validated = $request->validate([
        'start_date' => 'required|date', // Validate start_date is a valid date
        'end_date' => 'required|date|after_or_equal:start_date', // Ensure end_date is not before start_date
    ]);

    // Get the validated start and end dates
    $startDate = $validated['start_date'];
    $endDate = $validated['end_date'];

    // Return the Excel download for the sales report
    return Excel::download(new SalesReportExport($startDate, $endDate), 'sales_report.xlsx');

}


public function getEmployeeSalesReport(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $query = Sale::select(
        'sales.employee_id',
        DB::raw('SUM(DISTINCT sales.total) as total_sales'),
        DB::raw('SUM(sale_details.quantity) as total_items')
    )
    ->leftJoin('sale_details', 'sales.id', '=', 'sale_details.sale_id')
    ->groupBy('sales.employee_id');

    // Apply date filters
    if ($startDate) {
        $query->whereDate('sales.created_at', '>=', $startDate);
    }
    if ($endDate) {
        $query->whereDate('sales.created_at', '<=', $endDate);
    }

    $sales = $query->get();
     // Calculate grand totals
     $grandTotalSales = $sales->sum('total_sales');
     $grandTotalItems = $sales->sum('total_items');

    if ($request->ajax()) {
        return response()->json([
            'html' => view('reports.employee_report', compact('sales','grandTotalSales','grandTotalItems'))->render(),
        ]);
    }

    return view('reports.employee_sales', compact('sales','grandTotalSales','grandTotalItems'));
}

public function exportEmployeeSalesReport(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    return Excel::download(
        new EmployeeSalesReportExport($startDate, $endDate),
        'EmployeeSalesReport.xlsx'
    );
}

   
}
