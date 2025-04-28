<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Menu;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $id = $request->id;
        $image = $request->image;
        $name = $request->name;
        $price = $request->price;

        $menu = Menu::find($id);
        $cart = Cart::where('user_id', auth()->user()->id)->where('restaurant_id', $menu->restaurant_id)->first();
        if ($cart) {
            $items = json_decode($cart->items, true);
            $items[$id] = [
                'image' => $image,
                'name' => $name,
                'price' => $price,
                'quantity' => isset($items[$id]['quantity']) ? $items[$id]['quantity'] + 1 : 1,
            ];
            $cart->items = json_encode($items);
            $cart->total_price += $price;
            $cart->total_items += 1;
        } else {
            $cart = new Cart();
            $cart->user_id = auth()->user()->id;
            $cart->restaurant_id = $menu->restaurant_id;
            $cart->items = json_encode([
                $id => [
                    'image' => $image,
                    'name' => $name,
                    'price' => $price,
                    'quantity' => 1,
                ],
            ]);
            $cart->total_price = $price;
            $cart->total_items = 1;
        }

        $cart->save();

        return response()->json(['cart' => $cart]);
    }

    public function removeFromCart(Request $request)
    {
        $id = $request->id;
        $cart = Cart::where('user_id', auth()->user()->id)->first();
        $items = json_decode($cart->items, true);

        if (isset($items[$id])) {
            $cart->total_price -= $items[$id]['price'];
            $cart->total_items -= 1;
            $items = json_decode($cart->items, true);
            $items[$id]['quantity'] -= 1; 
            $cart->items = json_encode($items);
            $cart->save();
        }
        return response()->json(['cart' => $cart]);
    }

    public function clearFromCart(Request $request)
    {
        $id = $request->id;
        $cart = Cart::where('user_id', auth()->user()->id)->first();
        $items = json_decode($cart->items, true);

        if (isset($items[$id])) {
            $cart->total_price -= $items[$id]['price'] * $items[$id]['quantity'];
            $cart->total_items -= $items[$id]['quantity'];
            $cart->total_price -= round($items[$id]['price']) * $items[$id]['quantity'];
            unset($items[$id]);
            $cart->items = json_encode($items);
            $cart->save();
        }

        return response()->json(['cart' => $cart]);
    }

    public function getLatestCart(Request $request)
    {
        $restaurantId = $request->restaurant_id;
        $cart = [];
        if ($restaurantId == null) {
            $cart = auth()->user()->cart;
        } else {
            $cart = Cart::where('user_id', auth()->user()->id)->where('restaurant_id', $restaurantId)->first();


        }

        if ($cart) {
            $items = json_decode($cart->items, true);
            $cart->items = $items;
        }

        return response()->json(['cart' => $cart]);
    }
}