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
    public function index()
    {
        $orders = Order::with('customer')->paginate(10); 

        return view('dashboard.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $restaurants = Restaurant::all();

        return view('dashboard.order.create', compact('users', 'restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'restaurant_id' => 'required|exists:restaurants,id',
            'status' => 'required|in:New,Pending,Proceeding,Completed,Cancelled',
            'type' => 'required|in:Pickup,Delivery',
            'total_price' => 'nullable|numeric|min:0',
            'payment_status' => 'nullable|in:Paid,Unpaid',
            'transaction_id' => 'nullable|string|max:255',
            'points' => 'nullable|integer|min:0',
        ]);

        Order::create($validated);

        return redirect()->route('dashboard.order.index')->with('alert', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('dashboard.order.show', [
            'order' => Order::with('customer')->findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('dashboard.order.edit', [
            'order' => Order::with('customer')->findOrFail($id)
        ]);
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
    public function getOrderApproval()
    {
        $orders = Order::where('status', config('constant.status.order.new'))->paginate(10);

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
