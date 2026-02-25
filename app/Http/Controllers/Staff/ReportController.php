<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year ?? date('Y');

        $monthlyRevenue = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->whereYear('created_at', $year)
            ->where('payment_status', 'paid')
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyCustomers = User::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->where('role', 'customer')
            ->groupBy('month')
            ->pluck('total', 'month');

        return view('staff.reports.index', compact(
            'monthlyRevenue',
            'monthlyCustomers',
            'year'
        ));
    }

    public function sales()
    {
        $orders = Order::with('user')
            ->where('payment_status', 'paid')
            ->latest()
            ->paginate(10);

        $totalRevenue = Order::where('payment_status', 'paid')
            ->sum('total_amount');

        $totalTransactions = Order::where('payment_status', 'paid')
            ->count();

        return view('staff.reports.sales', compact(
            'orders',
            'totalRevenue',
            'totalTransactions'
        ));
    }

    /**
     * Transaction monitoring
     */
    public function transaction()
    {
        $transactions = Order::with('user')
            ->latest()
            ->paginate(10);

        $total = Order::count();
        $pending = Order::where('payment_status', 'pending')->count();
        $paid = Order::where('payment_status', 'paid')->count();
        $totalValue = Order::where('payment_status', 'paid')
            ->sum('total_amount');

        return view('staff.reports.transaction', compact(
            'transactions',
            'total',
            'pending',
            'paid',
            'totalValue'
        ));
    }
}