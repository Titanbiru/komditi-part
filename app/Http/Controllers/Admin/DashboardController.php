<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik User
        $totalAdmins = User::where('role', 'admin')->count();
        $totalStaff = User::where('role', 'staff')->count();
        $totalCustomers = User::where('role', 'user')->count();
        
        // Statistik Produk
        $totalProducts = Product::count();

        // Statistik Bulan Ini (Sales & Order)
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        // Total Transaksi Bulan Ini (Hanya yang tidak dibatalkan)
        $totalOrdersMonth = Order::whereMonth('created_at', $thisMonth)
                                    ->whereYear('created_at', $thisYear)
                                    ->where('shipment_status', '!=', 'cancelled')
                                    ->count();

        // Total Penjualan Bulan Ini (Hanya yang sudah dibayar/paid)
        $salesThisMonth = Order::whereMonth('created_at', $thisMonth)
                                ->whereYear('created_at', $thisYear)
                                ->where('payment_status', 'paid')
                                ->sum('grand_total');

        $lowStockProducts = Product::where('stock', '<', 10)
        ->orderBy('stock', 'asc')
        ->take(5)
        ->get();

        // Ambil 5 transaksi terbaru
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalAdmins', 
            'totalStaff', 
            'totalCustomers', 
            'totalProducts', 
            'totalOrdersMonth', 
            'salesThisMonth',
            'lowStockProducts',
            'recentOrders'    
            ));
    }
}