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
    
    /**
     * Display a listing of all product.
     */
    public function products(Request $request)
    {
        $query = Product::query();

        switch($request->type) {
            case 'Tyre':
                $query->where('category_product_type_id', 1);
                break;
            case 'Rims':
                $query->where('category_product_type_id', 2);
                break;
            case 'Tyre & Rims':
                $query->where('category_product_type_id', 3);
                break;
            default:
        }
            $products = $query->get();
        return view('web.products')->with([
            'products' => $products
        ]);
    }

    public function details(string $uuid) {
        $product = Product::where('uuid', $uuid)->first();

        if ($product) {
            return view('web.details')->with([
                'product' => $product
            ]);
        } else {
            return redirect()->route('wev.products')->with('alert', __('Product record does not exist!'));
        }
    }
}
