<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        body {
            font-family: "Khmer OS Battambang", Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .invoice {
            width: 300px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 8px;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 15px;
        }
        .invoice-header h1 {
            font-size: 18px;
            margin: 5px 0;
        }
        .invoice-header p {
            margin: 2px 0;
            font-size: 12px;
        }
        .invoice-details {
            margin-bottom: 15px;
        }
        .invoice-details p {
            margin: 3px 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #ccc;
            padding: 5px;
            font-size: 12px;
            text-align: left;
        }
        .totals {
            margin-top: 15px;
            font-size: 12px;
        }
        .totals p {
            margin: 2px 0;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 12px;
            font-style: italic;
        }
        .btn-print {
            display: block;
            margin: 10px auto;
            padding: 5px 15px;
            font-size: 12px;
            cursor: pointer;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
        }
        .btn-print:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="invoice">
        <div class="invoice-header">
            <h1>CHIMI Book Store</h1>
            <p>សង្កាត់បឹងកក់២​ ខណ្ឌទួលគោក​ រាជធានីភ្នំពេញ</p>
            <p>លេខទំនាក់ទំនង 081981627</p>
        </div>

        <div class="invoice-details">
            <p><strong>Invoice:</strong> {{ $sale->id }}</p>
            <p><strong>Name:</strong> Customer Name</p>
            <p><strong>Seller:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Date:</strong> {{ $sale->created_at->format('d-m-Y H:i:s') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $cartItem)
                <tr>
                    <td>{{ $cartItem->book->title_en }}</td>
                    <td>{{ number_format($cartItem->stock->selling_price, 2) }} $</td>
                    <td>{{ $cartItem->quantity }}</td>
                    <td>{{ number_format($cartItem->total, 2) }} $</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <p><strong>Total:</strong> {{ number_format($sale->total, 2) }} $</p>
            <p><strong>USD Equivalent:</strong> ${{ number_format($sale->total / 4000, 2) }}</p>
            <p><strong>Paid Payment:</strong> 0</p>
            <p><strong>Change Return:</strong> 0</p>
        </div>

        <div class="footer">
            -----------Thank You!-----------
            <br>
            {{-- Powered by Master-IT Solution --}}
        </div>

        <button id="print-invoice" class="btn-print">Print Invoice</button>
    </div>

   
</body>
</html>
