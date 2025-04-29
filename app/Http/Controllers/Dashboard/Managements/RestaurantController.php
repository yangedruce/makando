<?php

namespace App\Http\Controllers\Dashboard\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\User;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            $restaurants = Restaurant::paginate(10);
        } elseif ($user->hasRole('Restaurant Manager')) {
            $restaurants = Restaurant::where('user_id', $user->id)->paginate(10);
        } else {
            abort(403, 'Unauthorized action.');
        }

        return view('dashboard.management.restaurant.index', compact('restaurants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'Restaurant Manager');
        })->get();

        $categories = Category::where('user_id', auth()->id())->get();

        if (auth()->user()->hasRole('Admin')) {
            $categories = Category::all();
        }

        return view('dashboard.management.restaurant.create', compact('users', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'user_id' => auth()->user()->isAdmin() ? 'required|exists:users,id' : '',
        ]);

        $user = auth()->user();

        $restaurant = Restaurant::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'address' => $validated['address'],
            // 'status' => config('constant.status.restaurant.pending'),
            'status' => $user->isAdmin() ? config('constant.status.restaurant.active') : config('constant.status.restaurant.pending'),
            'is_opened' => false,
            'user_id' => auth()->user()->isAdmin() ? $validated['user_id'] : auth()->id(),
        ]);

        $categories = $request->input('categories', []);
        foreach ($categories as $category) {
            $restaurant->categories()->attach($category);
        }

        return redirect()->route('dashboard.management.restaurant.index')->with('alert', 'Restaurant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('dashboard.management.restaurant.show', [
            'restaurant' => Restaurant::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $user = auth()->user();

        if ($user->hasRole('Restaurant Manager') && $restaurant->status === 'Banned') {
            abort(403, 'You cannot edit a banned restaurant.');
        }

        if ($user->hasRole('Admin')) {
            $categories = Category::where('user_id', $restaurant->user_id)->get();
            $availableStatuses = config('constant.status.restaurant');
        } else { 
            $categories = Category::where('user_id', auth()->id())->get();
            $availableStatuses = [
                'Active' => 'Active',
                'Inactive' => 'Inactive',
            ];
        }

        return view('dashboard.management.restaurant.edit', compact('restaurant', 'categories', 'availableStatuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'status' => 'required|in:Active,Inactive,Pending,Banned',
            'is_opened' => 'required|boolean',
        ]);
    
        $restaurant = Restaurant::findOrFail($id);
    
        $updateData = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'address' => $validated['address'],
            'status' => $validated['status'],
            'is_opened' => $validated['is_opened'],
        ];
    
        if ($validated['status'] === 'Inactive' && !$restaurant->inactive_at) {
            $updateData['inactive_at'] = now();
        } elseif ($validated['status'] === 'Active') {
            $updateData['inactive_at'] = null;
        }

        $restaurant->categories()->sync($request->input('categories', []));
        
        $restaurant->update($updateData);
    
        return redirect()->route('dashboard.management.restaurant.index')->with('alert', 'Restaurant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $restaurant = Restaurant::with(['menus', 'orders', 'categories'])->findOrFail($id);

        if ($restaurant->menus()->exists() || $restaurant->orders()->exists() || $restaurant->categories()->exists()) {
            return redirect()->route('dashboard.management.restaurant.index')->with('alert', 'Cannot delete. This Restaurant has related Menus, Orders, or Categories.');
        }

        $restaurant->delete();

        return redirect()->route('dashboard.management.restaurant.index')->with('alert', 'Restaurant deleted successfully.');
    }

    /**
     * Display a listing of restaurants for approval.
     */
    public function getApproval()
    {
        $user = auth()->user();

        if (!$user->hasRole('Admin')) {
            abort(403, 'Unauthorized action.');
        }
        
        $restaurants = Restaurant::where('status', config('constant.status.restaurant.pending'))->paginate(10);

        return view('dashboard.management.approval.index', compact('restaurants'));
    }

    /**
     * Update the approval status of a restaurant.
     */
    public function updateApproval(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Active,Banned',
        ]);

        $restaurant = Restaurant::findOrFail($id);
        $restaurant->update(['status' => $validated['status']]);

        return redirect()->route('dashboard.management.restaurant-approval.index')->with('alert', 'Restaurant status updated successfully.');
    }
}
