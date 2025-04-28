<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\URL;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Restaurant::with(['user', 'categories'])->where('status', config('constant.status.restaurant.active'));

        if ($keyword = $request->keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        if ($categoryIds = $request->category_id) {
            $query->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            });
        }

        $restaurants = $query->paginate(10);

        $categories = Category::all();

        return view('dashboard.shop.index', [
            'restaurants' => $restaurants,
            'categories' => $categories,
            'request' => $request, 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $restaurant = Restaurant::with('user', 'categories', 'menus')->findOrFail($id);
        return view('dashboard.shop.show', compact('restaurant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function checkout()
    {
        $cart = auth()->user()->cart;

        if (!$cart || $cart->total_price <= 0) {
            return redirect()->back()->with('alert', 'Your cart is empty.');
        }

        return view('dashboard.shop.checkout.index', compact('cart'));
    }

    public function payment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $cart = auth()->user()->cart;

        if (!$cart || $cart->total_price <= 0) {
            return redirect()->back()->with('alert', 'Your cart is empty.');
        }

        $cart->type = $request->type;
        $cart->save();

        $lineItems = [];
        foreach (json_decode($cart->items) as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd', // or your currency
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => intval($item->price * 100), // Stripe expects amount in cents
                ],
                'quantity' => $item->quantity,
            ];
        }

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_email' => auth()->user()->email,
            'success_url' => route('dashboard.shop.checkout.success'),
            'cancel_url' => route('dashboard.shop.checkout.cancel'),
            'metadata' => [
                'cart_id' => $cart->id,
            ]
        ]);

        return redirect($session->url);
        
    }

    public function success()
    {
        $cart = auth()->user()->cart;
        $order = Order::create([
            'user_id' => auth()->user()->id,
            'restaurant_id' => $cart->restaurant_id,
            'status' => config('constant.status.order.new'),
            'type' => $cart->type,
            'total_price' => $cart->total_price,
            'payment_status' => config('constant.status.payment.paid'),
            'points' => round($cart->total_price),
        ]);

        foreach (json_decode($cart->items) as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $id,
                'quantity' => $item->quantity,
            ]);
        }

        $customer = auth()->user()->customer;
        $customer->total_points += $order->points;
        $customer->save();

        $cart->delete();
        
        return view('dashboard.shop.checkout.success');
    }
    public function cancel()
    {
        return view('dashboard.shop.checkout.cancel');
    }
}
