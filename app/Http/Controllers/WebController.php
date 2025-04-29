<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\CategoryBrand;
use App\Models\CategoryCondition;
use App\Models\CategoryRimSize;
use App\Models\CategorySetType;
use App\Models\CategoryTyreProfile;
use App\Models\CategoryVehicleType;
use App\Models\CategoryProductType;

class WebController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('web.index');
    }
}
