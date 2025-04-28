<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Restaurant;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('Admin')) {
            $orders = Order::with('customer')->paginate(10);
        } elseif ($user->hasRole('Restaurant Manager')) {
            $orders = Order::whereIn('restaurant_id', $user->restaurants->pluck('id'))->with('customer')->paginate(10);
        } elseif ($user->hasRole('Customer')) {
            $orders = Order::where('user_id', $user->id)->with('customer')->paginate(10);
        } else {
            abort(403, 'Unauthorized action.');
        }

        return view('dashboard.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $users = User::all();
    //     $restaurants = Restaurant::all();

    //     return view('dashboard.order.create', compact('users', 'restaurants'));
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'restaurant_id' => 'required|exists:restaurants,id',
    //         'status' => 'required|in:New,Pending,Proceeding,Completed,Cancelled',
    //         'type' => 'required|in:Pickup,Delivery',
    //         'total_price' => 'nullable|numeric|min:0',
    //         'payment_status' => 'nullable|in:Paid,Unpaid',
    //         'transaction_id' => 'nullable|string|max:255',
    //         'points' => 'nullable|integer|min:0',
    //     ]);

    //     Order::create($validated);

    //     return redirect()->route('dashboard.order.index')->with('alert', 'Order created successfully.');
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with('customer')->findOrFail($id);
        $user = $order->user;
        $address = $user->customer->address ?? '-';
        $phoneNo = $user->customer->phone_no ?? '-';

        return view('dashboard.order.show', compact('order', 'user', 'address', 'phoneNo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::with('customer')->findOrFail($id);

        return view('dashboard.order.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:New,Pending,Proceeding,Completed,Cancelled',
            'type' => 'required|in:Pickup,Delivery',
        ]);

        $order->update([
            'status' => $validated['status'],
            'type' => $validated['type'],
        ]);

        if ($order->status == 'Completed') {
            $customer = $order->user->customer;
            $customer->total_points += $order->points;
            $customer->save();
        }

        return redirect()->route('dashboard.order.index')->with('alert', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::with('orderItems')->findOrFail($id);

        if ($order->orderItems()->exists()) {
            return redirect()->route('dashboard.order.index')->with('alert', 'Cannot delete. This Order has related Order Items.');
        }
    
        $order->delete();
    
        return redirect()->route('dashboard.order.index')->with('alert', 'Order deleted successfully.');
    }

    /**
     * Get the list of orders for approval.
     */
    public function getOrderApproval(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('Admin')) {
            $orders = Order::where('status', config('constant.status.order.new'))->paginate(10);
        } elseif ($user->hasRole('Restaurant Manager')) {
            $orders = Order::where('status', config('constant.status.order.new'))
                ->whereIn('restaurant_id', $user->restaurants->pluck('id'))
                ->paginate(10);
        } else {
            abort(403, 'Unauthorized action.');
        }

        return view('dashboard.order.upcoming.index', compact('orders'));
    }

    /**
     * Update the order status to approved.
     */
    public function updateOrderApproval(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Proceeding,Cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $validated['status']]);

        return redirect()->route('dashboard.order.orderApproval')->with('alert', 'Order approved successfully.');
    }
}
