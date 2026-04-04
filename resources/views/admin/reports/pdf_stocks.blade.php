<!DOCTYPE html>
<html>
<head>
    <title>Stock Report - {{ date('d/m/Y') }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .period { font-size: 12px; color: #666; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 10px; font-size: 11px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; text-transform: uppercase; }
        .type-in { color: green; font-weight: bold; }
        .type-out { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin:0;">KOMDITI PART</h2>
        <h3 style="margin:5px 0;">STOCK MOVEMENT REPORT</h3>
    </div>

    <div class="period">
        <strong>Periode:</strong> {{ $start ?? 'Awal' }} s/d {{ $end ?? 'Sekarang' }} <br>
        <strong>Dicetak pada:</strong> {{ date('d M Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th style="text-align: center;">Type</th>
                <th style="text-align: center;">Amount</th>
                <th style="text-align: center;">Date & Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stockHistory as $h)
            <tr>
                <td>{{ $h->product_name }}</td>
                <td style="text-align: center;">
                    <span class="{{ $h->change_type == 'in' ? 'type-in' : 'type-out' }}">
                        {{ strtoupper($h->change_type) }}
                    </span>
                </td>
                <td style="text-align: center;">{{ $h->quantity }} Unit</td>
                <td style="text-align: center;">{{ date('d/m/Y H:i', strtotime($h->created_at)) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>