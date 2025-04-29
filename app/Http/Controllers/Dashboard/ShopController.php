<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Stripe\Stripe;
use Stripe\Coupon as StripeCoupon;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\URL;
use Exception;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Restaurant::with(['user', 'categories'])->where('status', config('constant.status.restaurant.active'));

        if ($user->hasRole('Admin')) {
            $query;
        } elseif ($user->hasRole('Restaurant Manager')) {
            $query->where('user_id', $user->id);
        } elseif ($user->hasRole('Customer')) {
            $query;
        } else {
            return redirect()->route('dashboard')->with('alert', 'Unauthorized access.');
        }

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
        $categories = Category::whereHas('restaurants', function ($q) {
            $q->where('status', config('constant.status.restaurant.active'));
        })->distinct()->get();

        return view('dashboard.shop.index', [
            'restaurants' => $restaurants,
            'categories' => $categories,
            'request' => $request, 
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $restaurant = Restaurant::with('user', 'categories', 'menus')->findOrFail($id);
        
        return view('dashboard.shop.show', compact('restaurant'));
    }

    public function checkout(Request $request)
    {
        if (!auth()->user()->isCustomer()) {
            return redirect()->route('dashboard')->with('alert', 'You are not a customer!');
        }

        $cart = Cart::where('user_id', auth()->user()->id)->where('restaurant_id', $request->restaurant_id)->first();
        
        if (!$cart || $cart->total_price <= 0) {
            return redirect()->back()->with('alert', 'Your cart is empty.');
        }

        return view('dashboard.shop.checkout.index', compact('cart'));
    }

    public function payment(Request $request)
    {
        if (!auth()->user()->isCustomer()) {
            return redirect()->route('dashboard')->with('alert', 'You are not a customer!');
        }
        
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $cart = Cart::where('user_id', auth()->user()->id)->where('restaurant_id', $request->restaurant_id)->first();
            session(['cart_id' => $cart->id]);
            if (!$cart || $cart->total_price <= 0) {
                return redirect()->back()->with('alert', 'Your cart is empty.');
            }
            $cart->redeem_points = ($request->redeem_points === 'true');
            $cart->type = $request->type;
            $cart->save();

            $coupon = null;
            if ($cart->redeem_points) {
                $total_points = auth()->user()->customer->total_points ?? 0;
                if ($cart->total_price < number_format(auth()->user()->customer->total_points/100, 2)) {
                    $total_points = $cart->total_price*100;
                }

                $coupon = StripeCoupon::create([
                    'amount_off' => $total_points,
                    'currency' => 'usd',
                    'duration' => 'once',
                ]);
            }

            $lineItems = [];
            foreach (json_decode($cart->items) as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd', 
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
                'discounts' => [[
                    'coupon' => $coupon->id ?? null,
                ]],
                'customer_email' => auth()->user()->email,
                'success_url' => route('dashboard.shop.checkout.success'),
                'cancel_url' => route('dashboard.shop.checkout.cancel')
            ]);

            return redirect($session->url);
        
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('alert', 'Invalid request.');
        }
    }

    public function success(Request $request)
    {
        if (!auth()->user()->isCustomer()) {
            return redirect()->route('dashboard')->with('alert', 'You are not a customer!');
        }
        
        $cart = Cart::find(session('cart_id'));

        $redeem_points = auth()->user()->customer->total_points ?? 0;
        if ($cart->redeem_points) {
            if ($cart->total_price < number_format(auth()->user()->customer->total_points/100, 2)) {
                $redeem_points = $cart->total_price*100;
            }
            $cart->total_price -= $redeem_points/100;
            $cart->save();
        }

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
        $customer->total_points -= $redeem_points;
        $customer->save();

        $cart->delete();
        session()->forget('cart_id');
        
        return view('dashboard.shop.checkout.success');
    }
    
    public function cancel()
    {
        if (!auth()->user()->isCustomer()) {
            return redirect()->route('dashboard')->with('alert', 'You are not a customer!');
        }
        
        return view('dashboard.shop.checkout.cancel');
    }
}
