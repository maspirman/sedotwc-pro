<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Models\Blog;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        // Statistics
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalServices = Service::where('status', 'active')->count();
        $totalBlogs = Blog::count();

        // Recent orders
        $recentOrders = Order::with(['user', 'service'])
                            ->latest()
                            ->take(5)
                            ->get();

        // Popular services
        $popularServices = Service::withCount('orders')
                                ->orderBy('orders_count', 'desc')
                                ->take(5)
                                ->get();

        // Monthly revenue data for chart
        $monthlyRevenue = Order::select(
                                DB::raw('MONTH(created_at) as month'),
                                DB::raw('YEAR(created_at) as year'),
                                DB::raw('SUM(total_price) as revenue')
                            )
                            ->where('status', 'completed')
                            ->whereYear('created_at', date('Y'))
                            ->groupBy('year', 'month')
                            ->orderBy('month')
                            ->get();

        // Order status distribution
        $orderStatuses = Order::select('status', DB::raw('count(*) as count'))
                            ->groupBy('status')
                            ->get();

        // Recent notifications
        $recentNotifications = Notification::forUser(auth()->id())
                                        ->latest()
                                        ->take(10)
                                        ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'totalCustomers',
            'totalServices',
            'totalBlogs',
            'recentOrders',
            'popularServices',
            'monthlyRevenue',
            'orderStatuses',
            'recentNotifications'
        ));
    }
}
