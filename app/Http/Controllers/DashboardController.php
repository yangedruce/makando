<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Customer;
use App\Models\User;
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
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            return view('dashboard.index', [
                'role' => 'Admin',
                'overallSales' => Order::paid()->completed()->withItems()->sum('total_price'),
                'todaySales' => Order::paid()->completed()->withItems()->whereDate('created_at', $today)->sum('total_price'),
                'overallOrders' => Order::paid()->completed()->withItems()->count(),
                'todayOrders' => Order::paid()->completed()->withItems()->whereDate('created_at', $today)->count(),
                'pendingOrders' => Order::paid()->where('status', 'New')->withItems()->whereDate('created_at', $today)->count(),
                'overallCustomers' => Customer::active()->count(),
                'todayCustomers' => Customer::active()->whereDate('created_at', $today)->count(),
                'overallRestaurants' => Restaurant::active()->count(),
                'todayRestaurants' => Restaurant::active()->whereDate('created_at', $today)->count(),
                'pendingRestaurants' => Restaurant::where('status', 'Pending')->whereDate('created_at', $today)->count(),
            ]);
        }

        if ($user->hasRole('Restaurant Manager')) {
            $restaurantIds = $user->restaurants->pluck('id');

            return view('dashboard.index', [
                'role' => 'Restaurant Manager',
                'overallSales' => Order::whereIn('restaurant_id', $restaurantIds)->paid()->completed()->withItems()->sum('total_price'),
                'todaySales' => Order::whereIn('restaurant_id', $restaurantIds)->paid()->completed()->withItems()->whereDate('created_at', $today)->sum('total_price'),
                'overallOrders' => Order::whereIn('restaurant_id', $restaurantIds)->paid()->completed()->withItems()->count(),
                'todayOrders' => Order::whereIn('restaurant_id', $restaurantIds)->paid()->completed()->withItems()->whereDate('created_at', $today)->count(),
                'pendingOrders' => Order::whereIn('restaurant_id', $restaurantIds)->paid()->where('status', 'New')->withItems()->whereDate('created_at', $today)->count(),
                'overallCustomers' => Customer::whereIn('user_id', Order::whereIn('restaurant_id', Auth::user()->restaurants->pluck('id'))->pluck('user_id'))->with('user')->active()->count(),
                'todayCustomers' => Customer::whereIn('user_id', Order::whereIn('restaurant_id', Auth::user()->restaurants->pluck('id'))->pluck('user_id'))->with('user')->active()->whereDate('created_at', $today)->count(),
                'overallRestaurants' => Restaurant::where('user_id', auth()->user()->id)->active()->count(),
                'todayRestaurants' => Restaurant::where('user_id', auth()->user()->id)->active()->whereDate('created_at', $today)->count(),
                'pendingRestaurants' => Restaurant::where('user_id', auth()->user()->id)->where('status', 'Pending')->whereDate('created_at', $today)->count(),
            ]);
        }

        if ($user->hasRole('Customer')) {
            return view('dashboard.index', [
                'role' => 'Customer',
                'totalSpending' => Order::paid()->completed()->where('user_id', $user->id)->sum('total_price'),
                'totalPoints' => Order::paid()->completed()->where('points', '>=', 0)->where('user_id', $user->id)->withItems()->sum('points'), 
                'totalOrders' => Order::paid()->completed()->where('user_id', $user->id)->withItems()->count(),
            ]);
        }

        abort(403, 'Unauthorized action.');
    }
}
