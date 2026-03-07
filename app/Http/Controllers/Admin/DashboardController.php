<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Burger;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $ordersToday = Order::whereDate('created_at', $today)->count();
        $revenueToday = Payment::whereDate('paid_at', $today)->sum('amount');
        $pendingOrders = Order::whereIn('status', ['pending', 'preparing'])->count();
        $cancelledToday = Order::whereDate('created_at', $today)->where('status', 'cancelled')->count();

        $topBurgers = Burger::withSum('orderItems', 'quantity')
            ->orderBy('order_items_sum_quantity', 'desc')
            ->take(5)
            ->get();

        // Monthly Orders
        $monthlyOrders = Order::select(DB::raw("EXTRACT(MONTH FROM created_at) as month"), DB::raw('count(*) as count'))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("EXTRACT(MONTH FROM created_at)"))
            ->pluck('count', 'month')
            ->toArray();

        $ordersData = [];
        for($i=1; $i<=12; $i++) {
            $ordersData[] = $monthlyOrders[$i] ?? 0;
        }

        // Sales by Category
        $categorySales = DB::table('order_items')
            ->join('burgers', 'order_items.burger_id', '=', 'burgers.id')
            ->select('burgers.category', DB::raw('sum(order_items.quantity) as total_quantity'))
            ->whereNotNull('burgers.category')
            ->groupBy('burgers.category')
            ->get();

        $categories = $categorySales->pluck('category');
        $salesData = $categorySales->pluck('total_quantity');

        return view('admin.dashboard', compact(
            'ordersToday', 'revenueToday', 'pendingOrders', 'cancelledToday', 'topBurgers',
            'ordersData', 'categories', 'salesData'
        ));
    }
}
