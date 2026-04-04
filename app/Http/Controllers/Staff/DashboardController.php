<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTransactions = Order::whereMonth('created_at', now()->month)->count();

        $totalSales = Order::whereMonth('created_at', now()->month)
                        ->sum('grand_total');

        $activeOrders = Order::whereIn('shipment_status', ['pending','processing','shipped','delivered','cancelled'])->count();

        $lowStock = Product::where('stock', '<', 5)->count();

        return view('staff.dashboard', compact(
            'totalTransactions',
            'totalSales',
            'activeOrders',
            'lowStock'
        ));
    }
}
