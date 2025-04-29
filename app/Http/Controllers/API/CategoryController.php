<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getCategories(Request $request)
    {
        $id = $request->manager_id;
        
        $categories = Category::where('user_id', $id)->get();

        return json_decode($categories);
    }
}