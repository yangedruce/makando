@php
    $total_points = auth()->user()->customer->total_points ?? 0;
    if ($cart->total_price < number_format(auth()->user()->customer->total_points/100, 2)) {
        $total_points = $cart->total_price*100;
    }
@endphp

<x-layouts.web>
    <form method="POST" action="{{ route('dashboard.shop.checkout.payment') }}"
        class="w-full md:w-4/5 lg:w-1/2 mx-auto px-2 md:px-4" x-data="{
            isDelivery: false,
            redeemPoints: false,
            totalPoints: @js($total_points),
            totalPrice: @js($cart->total_price),
            checkRedeemPoints(input) {
                this.redeemPoints = input.checked;
                const pointsValue = this.totalPoints / 100;
                if (this.redeemPoints) {
                    this.totalPrice = parseFloat(this.totalPrice) - pointsValue;
                } else {
                    this.totalPrice = parseFloat(this.totalPrice) + pointsValue;
                }
                this.totalPrice = parseFloat(this.totalPrice).toFixed(2);
            }
        }">
        @csrf
        <input type="hidden" name="restaurant_id" value="{{ $cart->restaurant_id }}">
        <x-title>Order Information</x-title>
        <div class="flex flex-col mt-4">
            <h2 class="text-lg font-bold text-black dark:text-white">Order Type:</h2>
            <div class="flex flex-wrap gap-4 md:gap-8">
                <label class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                    <input type="radio" name="type" value="Pickup"
                        class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                        @click="isDelivery = false" checked>
                    <span>{{ __('Pickup') }}</span>
                </label>
                <label class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                    <input type="radio" name="type" value="Delivery"
                        class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                        @click="isDelivery = true">
                    <span>{{ __('Delivery') }}</span>
                </label>
            </div>
        </div>

        <h2 class="text-lg font-bold text-black dark:text-white mt-4">Customer Details</h2>
        <x-text><span class="font-bold">Name:</span> {{ auth()->user()->name }}</x-text>
        @if (auth()->user()->customer)
            <x-text><span class="font-bold">Phone No:</span> {{ auth()->user()->customer->phone_no }}</x-text>
            <x-text x-show="isDelivery"><span class="font-bold">Address:</span>
                {{ auth()->user()->customer->address }}</x-text>
        @endif

        <h2 class="text-lg font-bold text-black dark:text-white mt-4">Restaurant Details</h2>
        <x-text><span class="font-bold">Restaurant:</span> {{ $cart->restaurant->name }}</x-text>
        <x-text><span class="font-bold">Address:</span> {{ $cart->restaurant->address }}</x-text>

        <h2 class="text-lg font-bold text-black dark:text-white mt-4">Order Details</h2>
        @foreach (json_decode($cart->items) as $item)
            <div class="flex items-center justify-between p-4 bg-neutral-100 dark:bg-neutral-700 rounded mt-4">
                <div class="flex items-center space-x-4">
                    @if ($item->image)
                        <img src="{{ asset($item->image) }}" alt="" class="w-12 h-12 object-cover rounded" />
                    @else
                        <x-text class="text-xs">{{ __('No Image') }}</x-text>
                    @endif
                    <div class="flex flex-col">
                        <p class="text-sm font-bold text-black dark:text-white">{{ $item->name }}</p>
                        <p class="text-sm text-neutral-600 dark:text-neutral-300">
                            ${{ number_format($item->price, 2) }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <p class="text-sm font-medium text-black dark:text-white">{{ $item->quantity }}x</p>
                </div>
            </div>
        @endforeach

        <div class="flex flex-col mt-4">
            <x-text><span class="font-bold">Total Amount:</span> $<span x-text="totalPrice"></span></x-text>
            <x-text><span class="font-bold">Points Earned:</span> {{ round($cart->total_price) }}</x-text>
        </div>

        <div class="flex flex-col mt-4">
            <div class="flex flex-wrap gap-4 md:gap-8">
                <label class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                    <span>{{ __('Redeem Points') }} <span x-text="totalPoints"></span> ($<span x-text="(totalPoints / 100).toFixed(2)"></span>)</span>
                    <input type="checkbox" name="redeem_points" value="true" @click="checkRedeemPoints($el)"
                        class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none">
                </label>
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-center justify-center md:justify-between w-full mt-12">
            <x-link href="{{ route('dashboard.shop.index') }}" style="outline">Back to Shop</x-link>
            <x-button type="submit">Proceed to Payment</x-button>
        </div>
    </form>
</x-layouts.web>
