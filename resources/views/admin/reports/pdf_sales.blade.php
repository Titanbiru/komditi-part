<!DOCTYPE html>
<html>
<head>
    <title>Sales Report - {{ $start }} to {{ $end }}</title>
    <style>
        @page { margin: 1cm; }
        body { font-family: 'Helvetica', sans-serif; color: #202020; font-size: 10pt; line-height: 1.4; }
        .header { border-bottom: 3px solid #CD2828; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24pt; font-weight: 900; color: #CD2828; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 9pt; font-weight: bold; color: #bababa; text-transform: uppercase; }
        
        .summary-box { background: #f9f9f9; padding: 15px; margin-bottom: 20px; border-radius: 10px; }
        .summary-box table { width: 100%; border: none; }
        .summary-box td { border: none; padding: 0; font-size: 9pt; font-weight: bold; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #202020; color: #ffffff; text-align: left; padding: 10px; font-size: 8pt; text-transform: uppercase; font-weight: 900; }
        td { padding: 10px; border-bottom: 1px solid #f0f0f0; font-size: 9pt; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-black { font-weight: 900; }
        .total-row { background-color: #CD2828; color: white; font-weight: 900; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sales Report</h1>
        <p>Komditi Part • Official Business Analytics</p>
    </div>

    <div class="summary-box">
        <table>
            <tr>
                <td>PERIODE: <span style="color:#202020">{{ $start ?? 'ALL' }} - {{ $end ?? 'ALL' }}</span></td>
                <td class="text-right">GENERATED: <span style="color:#202020">{{ date('d M Y H:i') }}</span></td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>PRODUCT</th>
                <th class="text-center">QTY SOLD</th>
                <th class="text-right">UNIT PRICE</th>
                <th class="text-right">SUBTOTAL</th>
            </tr>
        </thead>
        {{-- LOGIKA GROUPING TERAKHIR: FLATTEN & GROUP BY NAME --}}
        @php
            // 1. Ambil semua item dari semua order dan jadikan satu list datar (Flatten)
            // 2. Kelompokkan berdasarkan nama snapshot
            $groupedItems = $orders->flatMap(function($order) {
                return $order->items;
            })->groupBy('product_name_snapshot');

            $grandTotalRevenue = 0;
        @endphp

        <tbody>
            @forelse($groupedItems as $productName => $items)
                @php
                    // Hitung total Qty dan Subtotal untuk grup produk ini
                    $totalQty = $items->sum('quantity');
                    $unitPrice = $items->first()->product_price_snapshot;
                    $totalRowSales = $totalQty * $unitPrice;
                    
                    $grandTotalRevenue += $totalRowSales;
                @endphp
                <tr>
                    <td class="font-black">{{ strtoupper($productName) }}</td>
                    <td class="text-center font-black" style="color: #202020;">
                        {{ $totalQty }} UNITS
                    </td>
                    <td class="text-right">
                        Rp {{ number_format($unitPrice, 0, ',', '.') }}
                    </td>
                    <td class="text-right font-black" style="color: #CD2828;">
                        Rp {{ number_format($totalRowSales, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No sales records found.</td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr class="total-row">
                <td colspan="3" class="text-right" style="padding: 12px;">GRAND TOTAL REVENUE</td>
                <td class="text-right" style="padding: 12px;">
                    Rp {{ number_format($grandTotalRevenue, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>