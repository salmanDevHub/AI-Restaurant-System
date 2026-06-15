<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Food;
use App\Models\Category;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders'    => Order::count(),
            'today_orders'    => Order::whereDate('created_at', today())->count(),
            'total_revenue'   => Order::where('status','delivered')->sum('total'),
            'today_revenue'   => Order::where('status','delivered')->whereDate('created_at',today())->sum('total'),
            'total_users'     => User::where('role','user')->count(),
            'new_users_today' => User::where('role','user')->whereDate('created_at',today())->count(),
            'total_foods'     => Food::count(),
            'active_foods'    => Food::where('is_available',true)->count(),
            'pending_orders'  => Order::where('status','pending')->count(),
            'active_orders'   => Order::whereIn('status',['confirmed','preparing','ready','on_the_way'])->count(),
        ];

        $recentOrders = Order::with('user')->orderByDesc('created_at')->limit(10)->get();
        $topFoods     = Food::orderByDesc('total_orders')->limit(5)->get();

        // Revenue last 7 days
        $revenueData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date          = Carbon::today()->subDays($i);
            $revenueData[] = [
                'date'    => $date->format('D'),
                'revenue' => Order::where('status','delivered')->whereDate('created_at',$date)->sum('total'),
                'orders'  => Order::whereDate('created_at',$date)->count(),
            ];
        }

        $orderStatusCounts = [
            'pending'   => Order::where('status','pending')->count(),
            'preparing' => Order::where('status','preparing')->count(),
            'delivered' => Order::where('status','delivered')->count(),
            'cancelled' => Order::where('status','cancelled')->count(),
        ];

        return view('admin.dashboard.index', compact(
            'stats','recentOrders','topFoods','revenueData','orderStatusCounts'
        ));
    }
}