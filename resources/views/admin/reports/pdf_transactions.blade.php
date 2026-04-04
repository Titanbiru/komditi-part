<!DOCTYPE html>
<html>
<head>
    <title>Transaction Report - {{ date('d/m/Y') }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; font-size: 10px; }
        th { background-color: #f2f2f2; text-align: center; }
        .status-paid { color: #10b981; font-weight: bold; }
        .text-right { text-align: right; }
        .footer { margin-top: 30px; text-align: right; font-weight: bold; border-top: 2px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin:0;">KOMDITI PART</h2>
        <h3 style="margin:5px 0;">TRANSACTION SUMMARY REPORT</h3>
        <p style="font-size: 12px;">Periode: {{ $start }} - {{ $end }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Payment Status</th>
                <th>Shipping Status</th>
                <th>Grand Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $t)
            <tr>
                <td style="text-align: center;">{{ $t->order_number }}</td>
                <td style="text-align: center;">{{ $t->created_at->format('d/m/Y') }}</td>
                <td>{{ $t->user->name ?? 'Guest' }}</td>
                <td style="text-align: center;" class="{{ $t->payment_status == 'paid' ? 'status-paid' : '' }}">
                    {{ strtoupper($t->payment_status) }}
                </td>
                <td style="text-align: center;">{{ strtoupper($t->shipment_status) }}</td>
                <td class="text-right font-bold">Rp {{ number_format($t->grand_total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        TOTAL PAID VALUE: Rp {{ number_format($totalValue, 0, ',', '.') }}
    </div>
</body>
</html>