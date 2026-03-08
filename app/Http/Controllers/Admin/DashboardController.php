<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Burger;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $ordersToday    = Order::whereDate('created_at', $today)->count();
        $revenueToday   = Payment::whereDate('paid_at', $today)->sum('amount');
        $pendingOrders  = Order::whereIn('status', ['pending', 'preparing'])->count();
        $cancelledToday = Order::whereDate('created_at', $today)->where('status', 'cancelled')->count();

        $topBurgers = Burger::withSum('orderItems', 'quantity')
            ->orderBy('order_items_sum_quantity', 'desc')
            ->take(5)
            ->get();

        // Monthly Orders (bar chart)
        $monthlyOrders = Order::select(
                DB::raw("EXTRACT(MONTH FROM created_at) as month"),
                DB::raw('count(*) as count')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("EXTRACT(MONTH FROM created_at)"))
            ->pluck('count', 'month')
            ->toArray();

        $ordersData = [];
        for ($i = 1; $i <= 12; $i++) {
            $ordersData[] = (int) ($monthlyOrders[$i] ?? 0);
        }

        // Sales by Category PER MONTH (grouped bar chart)
        $allCategories = Burger::whereNotNull('category')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        $monthlyCategoryData = [];
        foreach ($allCategories as $category) {
            $rows = DB::table('order_items')
                ->join('burgers', 'order_items.burger_id', '=', 'burgers.id')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->select(DB::raw("EXTRACT(MONTH FROM orders.created_at) as month"), DB::raw('SUM(order_items.quantity) as qty'))
                ->where('burgers.category', $category)
                ->whereYear('orders.created_at', date('Y'))
                ->groupBy(DB::raw("EXTRACT(MONTH FROM orders.created_at)"))
                ->pluck('qty', 'month')
                ->toArray();

            $monthly = [];
            for ($i = 1; $i <= 12; $i++) {
                $monthly[] = (int) ($rows[$i] ?? 0);
            }
            $monthlyCategoryData[$category] = $monthly;
        }

        return view('admin.dashboard', compact(
            'ordersToday', 'revenueToday', 'pendingOrders', 'cancelledToday',
            'topBurgers', 'ordersData', 'allCategories', 'monthlyCategoryData'
        ));
    }
}
