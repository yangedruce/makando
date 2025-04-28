<?php

namespace App\Http\Controllers\Dashboard\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            $customers = Customer::with(['user.restaurants', 'orders.restaurant'])->paginate(10);
        } elseif ($user->hasRole('Restaurant Manager')) {
            $restaurantIds = $user->restaurants->pluck('id');
            $customers = Customer::whereHas('user.orders', function ($query) use ($restaurantIds) {
                $query->whereIn('restaurant_id', $restaurantIds);
            })->with(['user.restaurants', 'orders.restaurant'])->paginate(10);
        } else {
            abort(403, 'Unauthorized action.');
        }

        return view('dashboard.management.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.management.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone_no' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
            'total_points' => ['nullable', 'integer', 'min:0'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make('password'), 
            'is_force_password_change' => false,
        ]);

        Customer::create([
            'user_id' => $user->id,
            'phone_no' => $validated['phone_no'],
            'address' => $validated['address'],
            'total_points' => $validated['total_points'] ?? 0,
            'status' => $validated['status'],
        ]);

        return redirect()->route('dashboard.management.customer.index')->with('alert', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::with('user')->findOrFail($id);

        return view('dashboard.management.customer.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::with('user')->findOrFail($id);

        return view('dashboard.management.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = Customer::with('user')->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($customer->user_id)],
            'phone_no' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
            'total_points' => ['nullable', 'integer', 'min:0'],
        ]);

        $customer->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $customer->update([
            'phone_no' => $validated['phone_no'],
            'address' => $validated['address'],
            'status' => $validated['status'],
            'total_points' => $validated['total_points'] ?? 0,
        ]);

        return redirect()->route('dashboard.management.customer.index')->with('alert', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $user = $customer->user;

        $customer->delete();
        $user->delete();

        return redirect()->route('dashboard.management.customer.index')->with('alert', 'Customer deleted successfully.');
    }
}
