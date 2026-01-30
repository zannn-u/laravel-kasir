<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $transaction->invoice_code }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .meta {
            margin-bottom: 20px;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 10px;
        }

        .meta p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            text-align: left;
            padding: 5px;
            border-bottom: 1px solid #eee;
        }

        .text-right {
            text-align: right;
        }

        .total {
            font-weight: bold;
            font-size: 14px;
            margin-top: 10px;
            text-align: right;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #777;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>POS KASIR</h1>
        <p>Jl. Contoh No. 123, Jakarta</p>
    </div>

    <div class="meta">
        <p>Invoice: <strong>{{ $transaction->invoice_code }}</strong></p>
        <p>Date: {{ $transaction->created_at->format('d M Y H:i') }}</p>
        <p>Status: {{ ucfirst($transaction->status) }}</p>
        <p>Payment: {{ strtoupper($transaction->payment_method ?? 'CASH') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->details as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td class="text-right">{{ $detail->quantity }}</td>
                    <td class="text-right">{{ number_format($detail->price, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Grand Total: Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
    </div>

    <div class="footer">
        <p>Thank you for your purchase!</p>
    </div>
</body>

</html>