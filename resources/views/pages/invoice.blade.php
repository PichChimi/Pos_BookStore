<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="invoice">
        <h2>Invoice</h2>
        <p><strong>Sale ID:</strong> {{ $sale->id }}</p>
        <p><strong>Date:</strong> {{ $sale->created_at }}</p>
        <p><strong>Employee ID:</strong> {{ $sale->employee_id }}</p>
    
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Book</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $cartItem)
                    <tr>
                        <td>{{ $cartItem->book->title_en }}</td>
                        <td>{{ $cartItem->quantity }}</td>
                        <td>${{ number_format($cartItem->book->selling_price, 2) }}</td>
                        <td>${{ number_format($cartItem->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        <p><strong>Subtotal:</strong> ${{ number_format($sale->sub_total, 2) }}</p>
        <p><strong>Total:</strong> ${{ number_format($sale->total, 2) }}</p>
    </div>
</body>
</html>
