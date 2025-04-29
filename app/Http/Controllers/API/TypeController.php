<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;

class TypeController extends Controller
{
    public function getTypes(Request $request)
    {
        $id = $request->restaurant_id;
        
        $types = Type::where('restaurant_id', $id)->get();

        return json_decode($types);
    }
}