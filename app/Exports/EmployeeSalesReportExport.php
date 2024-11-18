<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;
class EmployeeSalesReportExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        // Fetch sales data grouped by employee
        $sales = Sale::select(
            'sales.employee_id',
            DB::raw('SUM(sales.total) as total_sales'),
            DB::raw('SUM(sale_details.quantity) as total_items')
        )
        ->leftJoin('sale_details', 'sales.id', '=', 'sale_details.sale_id')
        ->whereBetween('sales.created_at', [$this->startDate, $this->endDate])
        ->groupBy('sales.employee_id')
        ->with('employee')
        ->get();

        // Check if there are sales data; if not, return an empty collection
        if ($sales->isEmpty()) {
            return collect();
        }

        // Map the sales data to an array format
        $salesData = $sales->map(function ($sale) {
            return [
                'Employee Name' => $sale->employee->name ?? 'N/A',
                'Total Sales ($)' => number_format($sale->total_sales, 2),
                'Total Items Sold' => $sale->total_items,
            ];
        });

        // Calculate grand totals
        $grandTotalSales = $sales->sum('total_sales');
        $grandTotalItems = $sales->sum('total_items');

        // Add grand totals as the last row
        $salesData->push([
            'Employee Name' => 'Total:',
            'Total Sales ($)' => '$' . number_format($grandTotalSales, 2),
            'Total Items Sold' => $grandTotalItems,
        ]);

        return $salesData;
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Total Sales ($)',
            'Total Items Sold',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style the header row
        $sheet->getStyle('A1:C1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['argb' => '28a745'], // Green header color
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Apply borders to all rows and columns
        $sheet->getStyle('A2:C' . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Apply bold font and background color to the total row (last row)
        $sheet->getStyle('A' . $sheet->getHighestRow() . ':C' . $sheet->getHighestRow())->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['argb' => 'DFF0D8'], // Light green background
            ],
        ]);
    }
}
