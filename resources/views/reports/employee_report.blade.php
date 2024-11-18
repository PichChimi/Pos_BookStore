<div class="mb-3">
    <button onclick="window.print()" class="btn btn-secondary">Print Report</button>
    <a href="{{ route('employeeSalesReport.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-success">Export to Excel</a>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Employee</th>
            <th>Total (Cash)</th>
            <th>Total (Items)</th>
        </tr>
    </thead>
    <tbody>
        @forelse($sales as $sale)
        <tr>
            <td>{{ $sale->employee->name ?? 'Unknown' }}</td> <!-- Assuming employee relation -->
            <td>${{ number_format($sale->total_sales, 2) }}</td>
            <td>{{ $sale->total_items }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center">No sales data available.</td>
        </tr>
        @endforelse
        <tr>
            <th>Total</th>
            <th>{{ number_format($grandTotalSales, 2) }}$</th>
            <th>{{ $grandTotalItems }}</th>
        </tr>
    </tbody>
</table>
