<x-layouts.web>
    <form method="POST" action="{{ route('dashboard.shop.checkout.payment') }}" class="w-1/2 mx-auto px-4"
        x-data="{
            isDelivery: false,
        }"
    >
        @csrf
        <x-title>Order Information</x-title>
        <div class="flex gap-8 mt-4">
            <x-text>Order Type:</x-text>
            <label
                class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                <input type="radio" name="type"
                    value="Pickup"
                    class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                    @click="isDelivery = false"
                    checked
                >
                <span>{{ __('Pickup') }}</span>
            </label>
            <label
                class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                <input type="radio" name="type"
                    value="Delivery"
                    class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                    @click="isDelivery = true"
                >
                <span>{{ __('Delivery') }}</span>
            </label>
        </div>

        <h2 class="text-lg font-bold text-black dark:text-white mt-4">Customer Details</h2>
        <x-text>Name: {{ auth()->user()->name }}</x-text> 
        @if(auth()->user()->customer)
            <x-text>Phone No: {{ auth()->user()->customer->phone_no }}</x-text>
            <x-text x-show="isDelivery">Address: {{ auth()->user()->customer->address }}</x-text>
        @endif

        <h2 class="text-lg font-bold text-black dark:text-white mt-4">Restaurant Details</h2>
        <x-text>Restaurant: {{ $cart->restaurant->name }}</x-text> 
        <x-text>Address: {{ $cart->restaurant->address }}</x-text> 

        <h2 class="text-lg font-bold text-black dark:text-white mt-4">Order Details</h2>
        @foreach (json_decode($cart->items) as $item)
            <img src="{{asset($item->image)}}" alt="" srcset="">
            <x-text>Menu: {{ $item->name }}</x-text>
            <x-text>Price: ${{ number_format($item->price, 2) }}</x-text>
            <x-text>Quantity: {{ $item->quantity }}</x-text>
            
        @endforeach
        <x-text>Total Amount: ${{ number_format($cart->total_price, 2) }}</x-text>
        <x-text>Points Earned: {{ round($cart->total_price) }}</x-text>
        <x-button class="mt-8" type="submit">Proceed to Payment</x-button>
    </form>
    <div class="flex flex-col items-center justify-center">
        <a href="{{ route('dashboard.shop.index') }}" class="mt-6 text-blue-500 underline">Back to Shop</a>
    </div>
</x-layouts.web>
