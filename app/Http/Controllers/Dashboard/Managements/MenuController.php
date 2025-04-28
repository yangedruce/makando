<?php

namespace App\Http\Controllers\Dashboard\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Type;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('type')->paginate(10);
        return view('dashboard.management.menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();
        $restaurants = auth()->user()->restaurants ?? collect();
        return view('dashboard.management.menu.create', compact('types', 'restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'type_id' => 'required|exists:types,id',
            'restaurant_id' => 'required|exists:restaurants,id',
            'is_available' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $menu = Menu::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'type_id' => $validated['type_id'],
            'restaurant_id' => $validated['restaurant_id'],
            'is_available' => $validated['is_available'],
        ]);
    
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menu_images', 'public');
            $menu->image()->create(['path' => $path]);
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
        $types = Type::all();
        $restaurants = auth()->user()->restaurants ?? collect();
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
            'price' => 'required|numeric|min:0',
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
