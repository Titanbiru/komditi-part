<!DOCTYPE html>
<html>
<head>
    <title>Transaction Summary</title>
    <style>
        @page { margin: 1cm; }
        body { font-family: 'Helvetica', sans-serif; color: #202020; }
        .header { text-align: right; border-bottom: 5px solid #1BCFD5; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24pt; font-weight: 900; color: #202020; text-transform: uppercase; }
        
        table { width: 100%; border-collapse: collapse; }
        th { background: #f9f9f9; padding: 12px; text-align: left; font-size: 8pt; font-weight: 900; border-bottom: 1px solid #202020; }
        td { padding: 12px; font-size: 9pt; border-bottom: 1px solid #eee; }
        
        .status { font-weight: 900; font-size: 8pt; }
        .status-paid { color: #1BCFD5; }
        .status-unpaid { color: #CD2828; }
        
        .footer-total { margin-top: 20px; background: #202020; color: white; padding: 20px; text-align: right; border-radius: 0 0 15px 15px; }
        .footer-total small { font-size: 8pt; color: #1BCFD5; display: block; margin-bottom: 5px; }
        .footer-total span { font-size: 16pt; font-weight: 900; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Transactions</h1>
        <div style="font-weight: 900; color: #1BCFD5;">PERIODE: {{ $start }} - {{ $end }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ORDER ID</th>
                <th>DATE</th>
                <th>CUSTOMER</th>
                <th style="text-align: center;">PAYMENT</th>
                <th style="text-align: center;">SHIPPING</th>
                <th style="text-align: right;">GRAND TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $t)
            <tr>
                <td style="font-weight: 900;">#{{ $t->order_number }}</td>
                <td style="color: #666;">{{ $t->created_at->format('d/m/Y') }}</td>
                <td style="font-weight: bold; text-transform: uppercase;">{{ $t->user->name ?? 'GUEST' }}</td>
                <td style="text-align: center;">
                    <span class="status {{ $t->payment_status == 'paid' ? 'status-paid' : 'status-unpaid' }}">
                        {{ strtoupper($t->payment_status) }}
                    </span>
                </td>
                <td style="text-align: center; font-weight: bold; font-size: 8pt;">{{ strtoupper($t->shipment_status) }}</td>
                <td style="text-align: right; font-weight: 900;">Rp {{ number_format($t->grand_total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer-total">
        <small>TOTAL ACCUMULATED VALUE (PAID)</small>
        <span>Rp {{ number_format($totalValue, 0, ',', '.') }}</span>
    </div>
</body>
</html>