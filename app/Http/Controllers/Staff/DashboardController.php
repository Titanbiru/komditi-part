<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil waktu hari ini & bulan ini
        $today = Carbon::today();
        $thisMonth = Carbon::now()->month;

        // 1. Transaksi Hari Ini (Biar Staff tahu beban kerja hari ini)
        $totalTransactions = Order::whereDate('created_at', $today)->count();

        // 2. Pendapatan Bulan Ini (Hanya yang PAID)
        $totalSales = Order::whereMonth('created_at', $thisMonth)
                            ->where('payment_status', 'paid')
                            ->sum('grand_total');

        // 3. Pesanan AKTIF (Yang butuh tenaga Staff buat bungkus/kirim)
        // Kita buang 'delivered' dan 'cancelled' dari list active
        $activeOrders = Order::whereIn('shipment_status', ['pending', 'processing', 'shipped'])->count();

        // 4. Produk Stok Kritis (Batas 5 unit sesuai kode Mas)
        $lowStock = Product::where('stock', '<', 5)->count();

        // 5. List Produk Stok Rendah (Buat ditampilin di section bawah dashboard)
        $lowStockList = Product::where('stock', '<', 10)
                                ->orderBy('stock', 'asc')
                                ->take(5)
                                ->get();

        return view('staff.dashboard', compact(
            'totalTransactions',
            'totalSales',
            'activeOrders',
            'lowStock',
            'lowStockList'
        ));
    }
}