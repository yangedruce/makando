<?php

namespace App\Http\Controllers\Dashboard\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('restaurants', 'manager')->paginate(10); 
        return view('dashboard.management.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all(); 
        return view('dashboard.management.category.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',

        ]);
    
        Category::create([
            'name' => $validated['name'],
            'user_id' => $validated['user_id'],
        ]);
    
        return redirect()->route('dashboard.management.category.index')->with('alert', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('dashboard.management.category.show', [
            'category' => Category::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        $users = User::all();

        return view('dashboard.management.category.edit', compact('category', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);
    
        $category = Category::findOrFail($id);
    
        $category->update([
            'name' => $validated['name'],
            'user_id' => $validated['user_id'],
        ]);
    
        return redirect()->route('dashboard.management.category.index')->with('alert', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::with('restaurants')->findOrFail($id);

        if ($category->restaurants()->exists()) {
            return redirect()->route('dashboard.management.category.index')->with('alert', 'Cannot delete. This Category is linked to Restaurants.');
        }

        $category->delete();

        return redirect()->route('dashboard.management.category.index')->with('alert', 'Category deleted successfully.');
    }
}
