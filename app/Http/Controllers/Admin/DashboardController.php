<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAdmins = User::where('role', 'admin')->count();
        $totalStaff = User::where('role', 'staff')->count();
        $totalCustomers = User::where('role', 'user')->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();

        return view('admin.dashboard', compact(
                'totalAdmins', 'totalStaff', 'totalCustomers', 'totalProducts', 'totalOrders'
            ));
    }
    
}
