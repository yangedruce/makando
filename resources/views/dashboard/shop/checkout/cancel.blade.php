<x-layouts.web>
    <div class="flex flex-col items-center justify-center">
        <h2 class="text-lg font-bold text-black dark:text-white">Payment Cancelled. ❌</h2>
        <x-text class="mt-4 text-center">Your payment was not completed.</x-text>
        <x-link href="{{ route('dashboard.shop.index') }}" class="mt-6" style="primary">Back to Shop</x-link>
    </div>
</x-layouts.web>
