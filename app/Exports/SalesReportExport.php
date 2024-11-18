<?php

namespace App\Exports;

use App\Models\Sale;
use App\Models\SaleDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesReportExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
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
        // Fetch sales data based on the date range
        $sales = Sale::with(['details.book'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();

        // Check if there are sales data; if not, return an empty collection
        if ($sales->isEmpty()) {
            return collect();
        }

        // Calculate total sales and total items sold
        $totalSales = $sales->sum('total');
        $totalItemsSold = $sales->sum(function ($sale) {
            return $sale->details->sum('quantity');
        });

        // Map the sales data to an array format
        $salesData = $sales->map(function ($sale) {
            return [
                'Sale ID' => $sale->id,
                'Date' => $sale->created_at->format('d-m-Y'),
                'Customer' => $sale->customer->name ?? 'N/A',
                'Total Amount' => number_format($sale->total, 2),
                'Details' => $sale->details->map(function ($detail) {
                    return $detail->book->title_en . ' - ' . $detail->quantity . ' x $' . number_format($detail->unit_price, 2);
                })->join(', '),
            ];
        });

        // Add the total sales and total items sold as the last row
        $salesData->push([
            'Sale ID' => 'Total Sales:',
            'Date' => '',
            'Customer' => '',
            'Total Amount' => '$' . number_format($totalSales, 2),
            'Details' => 'Total Items Sold: ' . $totalItemsSold,
        ]);

        return $salesData;
    }

    public function headings(): array
    {
        return [
            'Sale ID',
            'Date',
            'Customer',
            'Total Amount',
            'Details',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style the header row
        $sheet->getStyle('A1:E1')->applyFromArray([
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

        // Apply border to all columns and rows
        $sheet->getStyle('A4:E' . ($sheet->getHighestRow()))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Apply bold font and background color to the total row (last row)
        $sheet->getStyle('A' . ($sheet->getHighestRow()))->applyFromArray([
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