<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tangkap tahun, default tahun sekarang
        $year = $request->get('year', date('Y'));

        // 2. Hitung Revenue per bulan (Hanya yang sudah PAID)
        $monthlyRevenue = collect(range(1, 12))->map(function ($month) use ($year) {
            return Order::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->where('payment_status', 'paid')
                ->sum('grand_total');
        });

        // 3. Hitung Customer Baru per bulan
        $monthlyCustomers = collect(range(1, 12))->map(function ($month) use ($year) {
            return User::where('role', 'user')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();
        });

        // 4. Ambil daftar tahun yang ada transaksinya buat dropdown
        $availableYears = Order::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
        
        if($availableYears->isEmpty()) $availableYears = collect([date('Y')]);

        return view('staff.reports.index', compact('monthlyRevenue', 'monthlyCustomers', 'year', 'availableYears'));
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
            ->paginate(5);

        // Statistik Card
        $totalRevenue = Order::where('payment_status', 'paid')
            ->when($start && $end, function($q) use ($start, $end) {
                return $q->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
            })->sum('grand_total');
        
        // Menghitung total quantity semua barang yang terjual
        $totalQuantitySold = OrderItem::whereHas('order', function($q) use ($start, $end) {
            $q->where('payment_status', 'paid')
            ->when($start && $end, function($query) use ($start, $end) {
                return $query->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
            });
        })->sum('quantity');

        // Menghitung berapa banyak jenis produk unik yang pernah terjual
        $totalProductsSold = OrderItem::whereHas('order', function($q) use ($start, $end) {
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

        return view('staff.reports.sales', compact('orders', 'totalRevenue', 'totalQuantitySold', 'totalProductsSold', 'bestSellingProducts','topProduct'));
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
            ->paginate(5);

        // Hitung stats berdasarkan filter
        
        $total = Order::count();
        $pending = Order::where('shipment_status', 'pending')->count();
        $paid = Order::where('payment_status', 'paid')->count();
        $totalValue = Order::where('payment_status', 'paid')
            ->when($start && $end, function($q) use ($start, $end) {
                return $q->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);
            })->sum('grand_total');
        
        return view('staff.reports.transactions', compact('transaction', 'total', 'pending', 'paid', 'totalValue'));
    }

    public function transactionShow(Order $order)
    {
        
        $order->load('items.product', 'user');
        return view('staff.reports.transaction_detail', compact('order'));
    }

    public function stock(Request $request)
    {
        $totalProducts = Product::count();
        $stockIn = Product::where('stock', '>', 0)->count();
        $stockOut = Product::where('stock', 0)->count();
        $outOfStockProducts = Product::where('stock', 0)->count();

        $start = $request->start;
        $end = $request->end;

        // Statistik tetap ambil total keseluruhan, tapi history bisa difilter berdasarkan tanggal

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
            ->paginate(5);
        return view('staff.reports.stocks', compact('totalProducts', 'stockIn', 'stockOut', 'outOfStockProducts', 'stockHistory'));
    }
}