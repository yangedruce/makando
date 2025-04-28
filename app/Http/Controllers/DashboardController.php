<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Restaurant;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = Carbon::today();

        $overallSales = Order::where('payment_status', 'Paid')
            ->where('status', 'Completed')
            ->whereHas('orderItems')
            ->sum('total_price');

        $todaySales = Order::where('payment_status', 'Paid')
            ->where('status', 'Completed')
            ->whereHas('orderItems')
            ->whereDate('created_at', $today)
            ->sum('total_price');

        $overallOrders = Order::where('status', 'Completed')
            ->where('payment_status', 'Paid')
            ->whereHas('orderItems')
            ->count();

        $todayOrders = Order::where('status', 'Completed')
            ->where('payment_status', 'Paid')
            ->whereDate('created_at', $today)
            ->whereHas('orderItems')
            ->count();

        $pendingOrders = Order::where('status', 'New')
            ->where('payment_status', 'Paid')
            ->whereDate('created_at', $today)
            ->whereHas('orderItems')
            ->count();

        $overallCustomers = Customer::where('status', 'Active')->count();

        $todayCustomers = Customer::where('status', 'Active')
            ->whereDate('created_at', $today)
            ->count();

        $overallRestaurants = Restaurant::where('status', 'Active')->count();

        $todayRestaurants = Restaurant::where('status', 'Active')
            ->whereDate('created_at', $today)
            ->count();

        $pendingRestaurants = Restaurant::where('status', 'Pending')
            ->whereDate('created_at', $today)
            ->count();

        return view('dashboard.index', [
            'overallSales' => $overallSales,
            'todaySales' => $todaySales,
            'overallOrders' => $overallOrders,
            'todayOrders' => $todayOrders,
            'pendingOrders' => $pendingOrders,
            'overallCustomers' => $overallCustomers,
            'todayCustomers' => $todayCustomers,
            'overallRestaurants' => $overallRestaurants,
            'todayRestaurants' => $todayRestaurants,
            'pendingRestaurants' => $pendingRestaurants,
        ]);
    }
}
