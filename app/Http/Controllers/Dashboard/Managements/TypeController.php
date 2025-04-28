<?php

namespace App\Http\Controllers\Dashboard\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::paginate(10); 
        return view('dashboard.management.type.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $restaurants = auth()->user()->restaurants ?? collect();

        return view('dashboard.management.type.create', [
            'restaurants' => $restaurants
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'restaurant_id' => ['required', 'exists:restaurants,id'],
        ]);
    
        Type::create($validated);
    
        return redirect()->route('dashboard.management.type.index')->with('alert', 'Type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('dashboard.management.type.show', [
            'type' => Type::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $type = Type::findOrFail($id);
        $restaurants = auth()->user()->restaurants ?? collect();

        return view('dashboard.management.type.edit', [
            'type' => $type,
            'restaurants' => $restaurants
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'restaurant_id' => ['required', 'exists:restaurants,id'],
        ]);
    
        $type = Type::findOrFail($id);
        $type->update($validated);
    
        return redirect()->route('dashboard.management.type.index')->with('alert', 'Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type = Type::with('menus')->findOrFail($id);

        if ($type->menus()->exists()) {
            return redirect()->route('dashboard.management.type.index')->with('alert', 'Cannot delete. This Type has related Menus.');
        }

        $type->delete();

        return redirect()->route('dashboard.management.type.index')->with('alert', 'Type deleted successfully.');
    }
}
