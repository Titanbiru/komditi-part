<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        //Report utama menampilkan chart revenue & customer per month

        $year = $request->year ?? date('Y');

        $monthlyRevenue = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->whereYear('created_at', $year)
            ->where('status', 'completed')
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyCustomers = User::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->where('role', 'customer')
            ->groupBy('month')
            ->pluck('total', 'month');

        return view('admin.reports.index', compact(
            'monthlyRevenue',
            'monthlyCustomers',
            'year'
        ));
    }

    public function sales()
    {
        $orders = Order::with('items.product')->latest()->paginate(10);

        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalTransactions = Order::where('payment_status', 'paid')->count();
        $completedTransactions = Order::where('shipment_status', 'completed')->count();
        $bestSellingProducts = Product::withSum('items as total_sold', 'quantity')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();
        return view('admin.report.sales', compact('orders', 'totalRevenue', 'totalTransactions', 'completedTransactions', 'bestSellingProducts'));
    }

    public function transaction()
    {
        $transaction = Order::latest()->paginate(10);

        $total = Order::count();
        $pending = Order::where('status', 'pending')->count();
        $paid = Order::where('payment_status', 'paid')->count();
        $totalValue = Order::where('payment_status', 'paid')->sum('total_amount');
        return view('admin.report.transaction', compact('transaction', 'total', 'pending', 'paid', 'totalValue'));
    }

    public function transactionShow(Order $order)
    {
        
        $order->load('items.product', 'user');
        return view('admin.report.transaction_detail', compact('order'));
    }

    public function stock()
    {
        $totalProducts = Product::count();
        $stockIn = Product::where('stock', '>', 0)->count();
        $stockOut = Product::where('stock', 0)->count();
        $outOfStockProducts = Product::where('stock', 0)->count();

        $stockHistory = DB::table('stock_histories')
            ->join('products', 'stock_histories.product_id', '=', 'products.id')
            ->select('products.name as product_name', 'stock_histories.change_type', 'stock_histories.quantity', 'stock_histories.created_at')
            ->orderBy('stock_histories.created_at', 'desc')
            ->paginate(10);
        return view('admin.report.stock', compact('totalProducts', 'stockIn', 'stockOut', 'outOfStockProducts', 'stockHistory'));
    }
}
