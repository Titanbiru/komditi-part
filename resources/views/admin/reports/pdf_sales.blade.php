
<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; font-size: 11px; }
        th { background-color: #CD2828; color: white; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SALES REPORT</h1>
        <p>KOMDITI PART - Periode: {{ $start }} s/d {{ $end }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Product Name</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Price</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                @foreach($order->items as $item)
                <tr>
                    <td class="text-center">{{ $order->created_at->format('d/m/y') }}</td>
                    <td>{{ $item->product_name_snapshot }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($item->product_price_snapshot, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #eee; font-weight: bold;">
                <td colspan="4" class="text-right">TOTAL REVENUE</td>
                <td class="text-right">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>