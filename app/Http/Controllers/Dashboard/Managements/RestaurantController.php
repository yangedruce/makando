<?php

namespace App\Http\Controllers\Dashboard\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurants = Restaurant::where('user_id', auth()->user()->id)->paginate(10);

        if(auth()->user()->isAdmin()) {
            $restaurants = Restaurant::paginate(10);
        }
        
        return view('dashboard.management.restaurant.index', compact('restaurants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.management.restaurant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
        ]);

        Restaurant::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'address' => $validated['address'],
            'status' => config('constant.status.restaurant.pending'),
            'is_opened' => false,
            'user_id' => auth()->id(), 
        ]);

        $categories = $request->input('categories');
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
        return view('dashboard.management.restaurant.edit', [
            'restaurant' => Restaurant::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
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

        $categories = $request->input('categories');
        foreach ($categories as $category) {
            $restaurant->categories()->sync($category);
        }
    
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
