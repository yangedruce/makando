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
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            $categories = Category::with('restaurants', 'manager')->paginate(10);
        } elseif ($user->hasRole('Restaurant Manager')) {
            $categories = Category::where('user_id', $user->id)->paginate(10);
        } else {
            abort(403, 'Unauthorized action.');
        }

        return view('dashboard.management.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'Restaurant Manager');
        })->get();
        return view('dashboard.management.category.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => auth()->user()->isAdmin() ? 'required|exists:users,id' : '',
        ]);
    
        Category::create([
            'name' => $validated['name'],
            'user_id' => auth()->user()->isAdmin() ? $validated['user_id'] : auth()->id(),
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
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'Restaurant Manager');
        })->get();

        return view('dashboard.management.category.edit', compact('category', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => auth()->user()->isAdmin() ? 'required|exists:users,id' : '',
        ]);

        $category = Category::findOrFail($id);

        if ($category->restaurants()->exists() && $category->user_id != $validated['user_id']) {
            return redirect()->back()->with('alert', 'Cannot update. This Category is linked to Restaurants.');
        }
    
        $category->update([
            'name' => $validated['name'],
            'user_id' => auth()->user()->isAdmin() ? $validated['user_id'] : auth()->id(),
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
