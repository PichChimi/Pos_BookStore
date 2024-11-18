<div class="mb-3">
    <button onclick="window.print()" class="btn btn-secondary">Print Report</button>
    <a href="{{ route('sales.report.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-success">Export to Excel</a>
</div>


<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sale ID</th>
            <th>Date</th>
            <th>Customer</th>
            <th>Total Amount</th>
            <th>Details</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($sales as $sale)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $sale->created_at->format('d-m-Y') }}</td>
                <td>N/A</td>
                <td>${{ number_format($sale->total, 2) }}</td>
                <td>
                    <ul>
                        @foreach ($sale->details as $detail)
                            <li>{{ $detail->book->title_en }} - {{ $detail->quantity }} x ${{ number_format($detail->unit_price, 2) }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No sales data available for this period.</td>
            </tr>
        @endforelse
        <tr>
            <th colspan="4" class="text-end">Total Sales:</th>
            <th>${{ number_format($totalSales, 2) }}</th>
            
        </tr>
        <tr>
            <th colspan="4" class="text-end">Total Items Sold:</th>
            <th>{{ $totalItemsSold }}</th>
        </tr>
    </tbody>
</table>


{{-- <p><strong>Total Sales:</strong> ${{ number_format($totalSales, 2) }}</p>
<p><strong>Total Items Sold:</strong> {{ $totalItemsSold }}</p> --}}
