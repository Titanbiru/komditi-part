<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\StockHistory;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tangkap tahun dari request, default tahun saat ini
        $year = $request->get('year', date('Y'));

        // 2. Ambil Revenue per bulan di tahun tersebut
        $monthlyRevenue = collect(range(1, 12))->map(function ($month) use ($year) {
            return Order::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->where('payment_status', 'paid')
                ->sum('grand_total');
        });

        // 3. Ambil Customer baru per bulan di tahun tersebut
        $monthlyCustomers = collect(range(1, 12))->map(function ($month) use ($year) {
            return User::where('role', 'user')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();
        });

        // Ambil daftar tahun unik dari data Order untuk dropdown (opsional tapi bagus)
        $availableYears = Order::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
        
        // Jika data kosong, pastikan tahun sekarang ada di list
        if($availableYears->isEmpty()) $availableYears = collect([date('Y')]);
        

        return view('admin.reports.index', compact(
            'monthlyRevenue',
            'monthlyCustomers',
            'year',
            'availableYears'
        ));
    }

    public function sales(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        // Ambil order yang sudah bayar saja untuk laporan sales
        $paidOrders = Order::where('payment_status', 'paid');
        
        $orders = Order::with('items.product')
            ->where('payment_status', 'paid')
            ->when($start && $end, function($q) use ($start, $end) {
                return $q->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
            })
            ->latest()
            ->paginate(10);

        // Statistik Card
        $totalRevenue = Order::where('payment_status', 'paid')
            ->when($start && $end, function($q) use ($start, $end) {
                return $q->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
            })->sum('grand_total');
        
        // Menghitung total quantity semua barang yang terjual
        $totalQuantitySold = \App\Models\OrderItem::whereHas('order', function($q) {
            $q->where('payment_status', 'paid');
        })->sum('quantity');

        // Menghitung berapa banyak jenis produk unik yang pernah terjual
        $totalProductsSold = \App\Models\OrderItem::whereHas('order', function($q) {
            $q->where('payment_status', 'paid');
        })->distinct('product_id')->count();

        // Produk Terlaris
        $bestSellingProducts = Product::withSum(['orderItems as total_sold' => function($query) {
            $query->whereHas('order', function($q) {
                $q->where('payment_status', 'paid');
            });
        }], 'quantity')
        ->orderByDesc('total_sold')
        ->take(5)
        ->get();

        // Ambil nama produk terlaris nomor 1 untuk card
        $topProduct = $bestSellingProducts->first()->name ?? '-';

        return view('admin.reports.sales', compact('orders', 'totalRevenue', 'totalQuantitySold', 'totalProductsSold', 'bestSellingProducts','topProduct'));
    }

    public function transactions(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        $transaction = Order::with('user')
            ->when($start && $end, function($q) use ($start, $end) {
                return $q->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
            })
            ->latest()
            ->paginate(10);

        // Hitung stats berdasarkan filter
        
        $total = Order::count();
        $pending = Order::where('shipment_status', 'pending')->count();
        $paid = Order::where('payment_status', 'paid')->count();
        $totalValue = Order::where('payment_status', 'paid')
            ->when($start && $end, function($q) use ($start, $end) {
                return $q->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
            })->sum('grand_total');
        
        return view('admin.reports.transactions', compact('transaction', 'total', 'pending', 'paid', 'totalValue'));
    }

    public function transactionShow(Order $order)
    {
        
        $order->load('items.product', 'user');
        return view('admin.reports.transactions-show', compact('order'));
    }

    public function stock(Request $request)
    {
        $totalProducts = Product::count();
        $stockIn = StockHistory::where('type', 'in')->sum('amount');
        $stockOut = StockHistory::where('type', 'out')->sum('amount');
        $outOfStockProducts = Product::where('stock', 0)->count();

        $start = $request->start;
        $end = $request->end;

        // Statistik tetap ambil total keseluruhan, tapi history bisa difilter berdasarkan tanggal

        $stockHistory = DB::table('stock_histories')
            ->join('products', 'stock_histories.product_id', '=', 'products.id')
            ->select(
                'stock_histories.product_id',
                'products.name as product_name', 
                'stock_histories.type as change_type', 
                'stock_histories.amount as quantity', 
                'stock_histories.created_at'
            )
            ->when($start && $end, function($q) use ($start, $end) {
                return $q->whereBetween('stock_histories.created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
                })
                ->orderBy('stock_histories.created_at', 'desc')
                ->paginate(10);

        return view('admin.reports.stocks', compact('totalProducts', 'stockIn', 'stockOut', 'outOfStockProducts', 'stockHistory'));
    }
                
    public function stocksHistory(Product $product)
    {
        $histories = StockHistory::with('user')
            ->where('product_id', $product->id)
            ->latest()
            ->paginate(10);

        return view('admin.reports.stocks_history', compact('product', 'histories'));
    }
    // --- 1. EXPORT SALES PDF ---
    public function exportSalesPdf(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        $orders = Order::with('items.product')
            ->where('payment_status', 'paid')
            ->when($start && $end, function($q) use ($start, $end) {
                return $q->whereBetween('created_at', [$start, $end]);
            })
            ->get();

        $totalRevenue = $orders->sum('grand_total');
        
        $pdf = Pdf::loadView('admin.reports.pdf_sales', compact('orders', 'totalRevenue', 'start', 'end'))
                ->setPaper('a4', 'portrait');

        return $pdf->download('Report-Sales-'.$start.'-to-'.$end.'.pdf');
    }

    // --- 2. EXPORT STOCKS PDF ---
    public function exportStocksPdf(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        $stockHistory = DB::table('stock_histories')
            ->join('products', 'stock_histories.product_id', '=', 'products.id')
            ->select(
                'products.name as product_name', 
                'stock_histories.type as change_type', 
                'stock_histories.amount as quantity', 
                'stock_histories.created_at'
            )
            ->when($start && $end, function($q) use ($start, $end) {
                return $q->whereBetween('stock_histories.created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
            })
            ->orderBy('stock_histories.created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.reports.pdf_stocks', compact('stockHistory', 'start', 'end'))
                ->setPaper('a4', 'portrait');

        return $pdf->download('Report-Stocks-'.$start.'-to-'.$end.'.pdf');
    }


    // --- 3. EXPORT TRANSACTIONS PDF ---
    public function exportTransactionsPdf(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        $transactions = Order::with('user')
            ->when($start && $end, function($q) use ($start, $end) {
                return $q->whereBetween('created_at', [$start, $end]);
            })
            ->latest()
            ->get();

        $totalValue = $transactions->where('payment_status', 'paid')->sum('grand_total');

        // Pakai Landscape karena kolom transaksi biasanya lebar (Order ID, User, Status, dll)
        $pdf = Pdf::loadView('admin.reports.pdf_transactions', compact('transactions', 'totalValue', 'start', 'end'))
                ->setPaper('a4', 'landscape');

        return $pdf->download('Report-Transactions-'.$start.'-to-'.$end.'.pdf');
    }

    public function invoice($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.reports.invoice', compact('order'));
    }
}
