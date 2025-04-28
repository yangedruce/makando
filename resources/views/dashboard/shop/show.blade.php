@php
    $title = $restaurant->name ?? 'Shop';
    $subtitle = $restaurant->description ?? 'View restaurant details and all menus';
@endphp

<x-layouts.dashboard>
    <x-slot:title>
        {{ $title }}
    </x-slot>
    <x-slot:subtitle>
        {{ $subtitle }}
    </x-slot>
    <div class="flex flex-col gap-y-1 mb-10">
        <p class="text-sm text-left text-neutral-800 dark:text-neutral-200"><span class="font-bold">Address:</span>
            {{ $restaurant->address }}</p>
        <p class="text-sm text-left text-neutral-800 dark:text-neutral-200">
            <span class="font-bold">Availability:</span>
            <span
                class="{{ $restaurant->is_opened ? 'bg-green-200 text-green-800 dark:text-green-800 rounded-full py-1 px-3 text-xs font-semibold' : 'bg-red-200 text-red-800 dark:text-red-800 rounded-full py-1 px-3 text-xs font-semibold' }}">
                {{ $restaurant->is_opened ? 'Open' : 'Closed' }}
            </span>
        </p>
        <p class="text-sm text-left text-neutral-800 dark:text-neutral-200">
            <span class="font-bold">Categories:</span>
            @foreach ($restaurant->categories as $index => $category)
                {{ $category->name }}@if (!$loop->last)
                    ,
                @endif
            @endforeach
        </p>
    </div>
    <div>
        <div class="space-y-4">
            <div class="flex justify-end">
                <x-link href="{{ route('dashboard.shop.index') }}" style="outline">{{ __('Back') }}</x-link>
            </div>

            @php
                $groupedMenus = $restaurant->menus->sortBy('type.name')->groupBy(function ($menu) {
                    return $menu->type->name ?? 'Uncategorized';
                });
            @endphp

            @foreach ($groupedMenus as $typeName => $menus)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold mb-4 text-black dark:text-white">{{ $typeName }}</h2>

                    <div class="grid gap-4 grid-cols-1 xl:grid-cols-2">
                        @foreach ($menus as $menu)
                            <div class="bg-white border rounded-md border-neutral-200 dark:border-neutral-800 dark:bg-neutral-800 p-4 flex flex-col items-center space-y-4"
                                x-data="{
                                    quantity: 0,
                                    id: @js($menu->id),
                                    image: @js($menu->image->path),
                                    name: @js($menu->name),
                                    price: @js($menu->price),
                                    increment() {
                                        this.quantity++;
                                        addToCart(this.id, this.image, this.name, this.price);
                                    },
                                    decrement() {
                                        this.quantity--;
                                        removeFromCart(this.id, this.image, this.name, this.price);
                                    }
                                }" x-init="setTimeout(() => {
                                    quantity = cart[id]?.quantity || 0;
                                }, 100);">
                                <div class="w-full h-32 overflow-hidden rounded-lg">
                                    @isset($menu->image->path)
                                        <img src="{{ asset($menu->image->path) }}" alt=""
                                            class="w-full h-full object-cover" />
                                    @else
                                        {{ __('No Image') }}
                                    @endisset
                                </div>

                                <div class="flex flex-col w-full gap-4">
                                    <div class="flex flex-col">
                                        <h3 class="text-lg font-bold text-black dark:text-white">{{ $menu->name }}
                                        </h3>
                                        <p class="text-neutral-700 dark:text-neutral-300">{{ $menu->description }}</p>
                                        <p class="text-neutral-700 dark:text-neutral-300">
                                            ${{ number_format($menu->price, 2) }}</p>
                                    </div>

                                    <div class="flex justify-end items-end">
                                        @if ($menu->is_available)
                                            <template x-if="quantity === 0">
                                                <button @click="increment()"
                                                    class="px-4 py-2 text-sm font-medium text-white bg-black border border-black rounded-md dark:text-black hover:bg-neutral-800 dark:bg-neutral-100 dark:hover:bg-white hover:border-neutral-800 dark:border-neutral-100 dark:hover:border-white disabled:pointer-events-none disabled:opacity-60 group">
                                                    Add to Cart
                                                </button>
                                            </template>
                                            <template x-if="quantity > 0">
                                                <div class="flex items-center space-x-2">
                                                    <button @click="decrement()"
                                                        class="w-8 h-8 text-sm flex items-center justify-center bg-neutral-200 dark:bg-neutral-700 rounded hover:bg-neutral-300 dark:hover:bg-neutral-600 text-black dark:text-white">
                                                        -
                                                    </button>
                                                    <span class="w-6 text-sm text-center text-black dark:text-white"
                                                        x-text="quantity"></span>
                                                    <button @click="increment()"
                                                        class="w-8 h-8 text-sm flex items-center justify-center bg-neutral-200 dark:bg-neutral-700 rounded hover:bg-neutral-300 dark:hover:bg-neutral-600 text-black dark:text-white">
                                                        +
                                                    </button>
                                                </div>
                                            </template>
                                        @else
                                            <span
                                                class="px-4 py-2 text-sm font-medium text-gray-500 bg-gray-200 rounded-md">Unavailable</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.dashboard>
