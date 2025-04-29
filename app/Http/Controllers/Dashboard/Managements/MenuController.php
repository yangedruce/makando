<?php

namespace App\Http\Controllers\Dashboard\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Type;
use App\Models\Restaurant;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            $menus = Menu::with('type')->paginate(10);
        } elseif ($user->hasRole('Restaurant Manager')) {
            $menus = Menu::whereIn('restaurant_id', $user->restaurants->pluck('id'))->with('type')->paginate(10);
        } else {
            abort(403, 'Unauthorized action.');
        }

        return view('dashboard.management.menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            $types = Type::all();
            $restaurants = Restaurant::all();
        } elseif ($user->hasRole('Restaurant Manager')) {
            $restaurants = Restaurant::where('user_id', $user->id)->get();
            $restaurantIds = $restaurants->pluck('id');
            $types = Type::whereIn('restaurant_id', $restaurantIds)->get();
        } else {
            abort(403, 'Unauthorized action.');
        }

        return view('dashboard.management.menu.create', compact('types', 'restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.5',
            'description' => 'required|string',
            'type_id' => 'required|exists:types,id',
            'restaurant_id' => 'required|exists:restaurants,id',
            'is_available' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $restaurant = Restaurant::findOrFail($validated['restaurant_id']);
        $menu = Menu::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'type_id' => $validated['type_id'],
            'restaurant_id' => $validated['restaurant_id'],
            'user_id' => auth()->user()->id,
            'is_available' => $validated['is_available'],
            'user_id' => auth()->user()->isAdmin() ? $restaurant->user_id : auth()->id(),
        ]);
    
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menu_images', 'public');
            $menu->image()->create(['path' => $path, 'name' => $menu->name]);
        }

        return redirect()->route('dashboard.management.menu.index')->with('alert', 'Menu created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $menu = Menu::with('type')->findOrFail($id);
        return view('dashboard.management.menu.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menu = Menu::with('type')->findOrFail($id);
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            $types = Type::all();
            $restaurants = Restaurant::all();
        } elseif ($user->hasRole('Restaurant Manager')) {
            $restaurants = Restaurant::where('user_id', $user->id)->get();
            $restaurantIds = $restaurants->pluck('id');
            $types = Type::whereIn('restaurant_id', $restaurantIds)->get();
        } else {
            abort(403, 'Unauthorized action.');
        }

        return view('dashboard.management.menu.edit', compact('menu', 'types', 'restaurants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $menu = Menu::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.5',
            'description' => 'required|string',
            'type_id' => 'required|exists:types,id',
            'restaurant_id' => 'required|exists:restaurants,id',
            'is_available' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $menu->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'type_id' => $validated['type_id'],
            'restaurant_id' => $validated['restaurant_id'],
            'is_available' => $validated['is_available'],
            'user_id' => auth()->user()->isAdmin() ? $menu->user_id : auth()->id(),
        ]);
    
        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image->path); 
                $menu->image->delete(); 
            }
        
            $path = $request->file('image')->store('menu_images', 'public');
            $menu->image()->create([
                'path' => $path,
                'name' => $request->file('image')->getClientOriginalName(),
            ]); 
        }

        return redirect()->route('dashboard.management.menu.index')->with('alert', 'Menu updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = Menu::with('image')->findOrFail($id);

        if ($menu->image) {
            Storage::disk('public')->delete($menu->image->path);
            $menu->image->delete();
        }

        $menu->delete();

        return redirect()->route('dashboard.management.menu.index')->with('alert', 'Menu deleted successfully.');
    }
}
