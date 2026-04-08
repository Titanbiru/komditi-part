<!DOCTYPE html>
<html>
<head>
    <title>Stock Report - {{ date('d/m/Y') }}</title>
    <style>
        @page { margin: 1cm; }
        body { font-family: 'Helvetica', sans-serif; color: #202020; font-size: 10pt; }
        .header { border-bottom: 3px solid #202020; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 22pt; font-weight: 900; text-transform: uppercase; }
        
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 8pt; font-weight: 900; }
        .badge-in { background-color: #e6fffa; color: #2c7a7b; }
        .badge-out { background-color: #fff5f5; color: #c53030; }

        table { width: 100%; border-collapse: collapse; }
        th { border-bottom: 2px solid #202020; text-align: left; padding: 12px 10px; font-size: 8pt; font-weight: 900; }
        td { padding: 12px 10px; border-bottom: 1px solid #f0f0f0; font-size: 9pt; }
        
        .info-table { width: 100%; margin-bottom: 20px; font-size: 9pt; font-weight: bold; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Stock Movement</h1>
        <div style="font-weight: 900; color: #CD2828;">KOMDITI PART INVENTORY</div>
    </div>

    <table class="info-table">
        <tr>
            <td>PERIODE: {{ $start ?? 'AWAL' }} - {{ $end ?? 'SEKARANG' }}</td>
            <td style="text-align: right;">PRINTED BY ADMIN: {{ date('d/m/Y H:i') }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>PRODUCT NAME</th>
                <th style="text-align: center;">TYPE</th>
                <th style="text-align: center;">AMOUNT</th>
                <th style="text-align: right;">DATE & TIME</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stockHistory as $h)
            <tr>
                <td style="font-weight: bold; text-transform: uppercase;">{{ $h->product_name }}</td>
                <td style="text-align: center;">
                    <span class="badge {{ $h->change_type == 'in' ? 'badge-in' : 'badge-out' }}">
                        {{ strtoupper($h->change_type) }}
                    </span>
                </td>
                <td style="text-align: center; font-weight: 900;">{{ $h->quantity }} UNITS</td>
                <td style="text-align: right; color: #bababa;">{{ date('d/m/Y H:i', strtotime($h->created_at)) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>