<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total counts

        $totalOrders = Order::count();

        $totalProducts = Product::count();

        $totalUsers = User::where('role', 'user')->count();

        $totalCategories = Category::count();

        // Monthly revenue

        $monthlyData = DB::table('orders')
            ->selectRaw('
                MONTH(created_at) as month_number,
                MONTHNAME(created_at) as month_name,
                SUM(total) as revenue
            ')
            ->where('status', Order::STATUS_COMPLETED)
            ->groupBy('month_number', 'month_name')
            ->orderBy('month_number')
            ->get();

        $monthlyLabels = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        $monthlyRevenue = array_fill(0,12,0);

        foreach ($monthlyData as $data) {
            $index = $data->month_number - 1; 
            $monthlyRevenue[$index] = $data->revenue;
        }

        /// Weekly revenue    
        $weeklyData = DB::table('orders')
            ->selectRaw('
                WEEK(created_at) as week,
                SUM(total) as revenue
            ')
            ->where('status', Order::STATUS_COMPLETED)
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        $weeklyLabels = $weeklyData
            ->pluck('week')
            ->map(fn($week) => 'Week ' . $week)
            ->toArray();

        $weeklyRevenue = $weeklyData
            ->pluck('revenue')
            ->toArray();

        // Yearly revenue    

        $yearlyData = DB::table('orders')
            ->selectRaw('
                YEAR(created_at) as year,
                SUM(total) as revenue
            ')
            ->where('status', Order::STATUS_COMPLETED)
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        $yearlyLabels = $yearlyData
            ->pluck('year')
            ->toArray();

        $yearlyRevenue = $yearlyData
            ->pluck('revenue')
            ->toArray();

        // Total revenue    

        $totalRevenue = DB::table('orders')
            ->where('status', Order::STATUS_COMPLETED)
            ->sum('total');

        // Completed orders

        $completedOrders = DB::table('orders')
            ->where('status', Order::STATUS_COMPLETED)
            ->count();

        // Pending orders

        $pendingOrders = DB::table('orders')
            ->where('status', Order::STATUS_PENDING)
            ->count();

        // Today's revenue

        $todayRevenue = DB::table('orders')
            ->where('status', Order::STATUS_COMPLETED)
            ->whereDate('created_at', today())
            ->sum('total');


        // Today's orders

        $todayOrders = DB::table('orders')
            ->where('status', Order::STATUS_COMPLETED)
            ->whereDate('created_at', today())
            ->count();


        return view('admin.dashboard', compact(

            'totalOrders',
            'totalProducts',
            'totalUsers',
            'totalCategories',

            'monthlyLabels',
            'monthlyRevenue',

            'weeklyLabels',
            'weeklyRevenue',

            'yearlyLabels',
            'yearlyRevenue',

            'totalRevenue',
            'completedOrders',
            'pendingOrders',

            'todayRevenue',
            'todayOrders'
        ));
    }
}
