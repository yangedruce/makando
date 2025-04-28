<header class="sticky top-0 z-20 w-full bg-white dark:bg-neutral-950" x-data="{
    navbarHeight: null,
    isScrolled: false,
}" x-init="navbarHeight = $el.clientHeight;
isScrolled = window.scrollY > 0;"
    :class="isScrolled ? 'border-b border-neutral-200 dark:border-neutral-800' :
        'border-transparent dark:border-transparent'"
    @scroll.window="

        // Toggle navbar appearance
        isScrolled = window.scrollY > 0;
    ">
    <div class="flex items-center justify-between w-full h-16 max-w-screen-xl px-4 mx-auto sm:px-6 lg:px-8">
        {{-- Sidebar menu open button --}}
        <div class="flex items-center justify-between gap-2">

            @if (auth()->check() && auth()->user()->email_verified_at)
                <x-button class="-ml-2 group lg:hidden" style="icon" aria-label="Open sidebar menu."
                    @click="$dispatch('open-sidebar-menu')">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 stroke-neutral-500 dark:stroke-neutral-400 group-hover:stroke-black dark:group-hover:stroke-white"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 6l16 0" />
                        <path d="M4 12l16 0" />
                        <path d="M4 18l16 0" />
                    </svg>
                </x-button>
            @endif

            <x-link href="{{ route('dashboard') }}" class="hidden md:inline-block ">
                <span class="text-lg font-bold text-black dark:text-white">{{ config('app.name', 'Makando') }}</span>
            </x-link>
        </div>

        <div class="flex items-center gap-3">
            @if (auth()->user()->customer)
                <x-text>Points: {{ auth()->user()->customer->total_points }}</x-text>
            @endif
            <div class="flex items-center gap-1">
                <x-link href="#" class="block p-2 group relative" aria-label="Go to cart."
                    @click.prevent="cartOpen = true">
                    <span class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 stroke-neutral-500 dark:stroke-neutral-400 group-hover:stroke-black dark:group-hover:stroke-white"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M17 17h-11v-14h-2" />
                            <path d="M6 5l14 1l-1 7h-13" />
                        </svg>

                        <div x-show="Object.values(cart).reduce((total, item) => total + item.quantity, 0) > 0"
                            class="absolute -top-2 -right-2 min-w-[18px] h-[18px] px-1 text-[10px] font-semibold text-white bg-red-700 rounded-full flex items-center justify-center leading-none"
                            x-text="Object.values(cart).reduce((total, item) => total + item.quantity, 0)">
                        </div>
                    </span>
                </x-link>

                {{-- Dark mode toggle dropdown menu --}}
                @include('layouts.partials.dark-mode-toggle')
            </div>

            {{-- Settings dropdown menu --}}
            <x-dropdown aria-label="Toggle settings dropdown menu.">
                <x-slot name="trigger">{{ __('Settings') }}</x-slot>
                <x-slot name="menu">
                    @if (Route::has('profile.edit'))
                        <x-dropdown-link href="{{ route('profile.edit') }}">{{ __('Profile') }}</x-dropdown-link>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-button type="submit">
                            {{ __('Log Out') }}
                        </x-dropdown-button>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>

    {{-- Cart Sidebar --}}
    <div x-show="cartOpen" x-data="{
        breakpointSize: 1024,
        isClickOutside(event) {
            if (!event.target.closest('#cart-sidebar-content')) {
                cartOpen = false;
            }
        }
    }"
        @click="if (window.innerWidth < breakpointSize) isClickOutside(event)"
        class="fixed inset-0 z-30 flex justify-end">

        <div class="fixed inset-0 bg-neutral-500/50 dark:bg-black/70" @click="cartOpen = false"></div>

        <div id="cart-sidebar-content"
            class="fixed top-0 right-0 h-full w-full xl:w-2/5 max-w-full px-4 sm:px-6 lg:px-8 overflow-y-auto bg-white dark:bg-neutral-800 border-l border-neutral-200 dark:border-neutral-800 shadow-lg transform transition-transform translate-x-0"
            x-show="cartOpen">
            <div class="flex justify-between items-center py-4">
                <h2 class="text-lg font-bold text-black dark:text-white">Your Cart</h2>
                <button @click="cartOpen = false" class="text-neutral-500 hover:text-black dark:hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 stroke-neutral-500 dark:stroke-neutral-400 group-hover:stroke-black dark:group-hover:stroke-white"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M18 6l-12 12" />
                        <path d="M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex flex-col space-y-4 pb-6">
                <template x-if="Object.values(cart).reduce((total, item) => total + item.quantity, 0) === 0">
                    <div class="p-4 bg-neutral-100 dark:bg-neutral-700 rounded">
                        <p class="text-sm font-medium text-black dark:text-white">Cart is empty.</p>
                    </div>
                </template>
                <template x-for="(item, idx) in cart" :key="idx">
                    <div class="flex items-center justify-between p-4 bg-neutral-100 dark:bg-neutral-700 rounded"
                        x-data="{
                            quantity: item.quantity,
                            id: idx,
                            image: item.image,
                            name: item.name,
                            price: item.price,
                            increment() {
                                this.quantity++;
                                addToCart(this.id, this.image, this.name, this.price);
                            },
                            decrement() {
                                this.quantity--;
                                removeFromCart(this.id);
                            },
                            remove() {
                                this.quantity = 0;
                                clearFromCart(this.id);
                            }
                        }">
                        <div class="flex items-center space-x-4">
                            <img :src="window.location.protocol + '//' + window.location.host + '/' + item.image"
                                alt="" class="w-12 h-12 object-cover rounded" />
                            <div class="flex flex-col">
                                <p class="text-sm font-bold text-black dark:text-white" x-text="item.name"></p>
                                <p class="text-sm text-neutral-600 dark:text-neutral-300" x-text="'$' + item.price"></p>

                                {{-- Increment / Decrement controls --}}
                                <div class="flex items-center space-x-2 mt-2">
                                    <button type="button" @click="decrement()" {{-- @click="item.quantity > 1 ? item.quantity-- : delete cart[idx]" --}}
                                        class="w-6 h-6 text-xs flex items-center justify-center bg-neutral-200 dark:bg-neutral-900 rounded hover:bg-neutral-300 dark:hover:bg-neutral-800 text-black dark:text-white">
                                        -
                                    </button>

                                    <span class="w-6 text-xs text-center text-black dark:text-white"
                                        x-text="item.quantity"></span>

                                    <button type="button" @click="increment()" {{-- @click="item.quantity++" --}}
                                        class="w-6 h-6 text-xs flex items-center justify-center bg-neutral-200 dark:bg-neutral-900 rounded hover:bg-neutral-300 dark:hover:bg-neutral-800 text-black dark:text-white">
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <p class="text-sm font-medium text-black dark:text-white" x-text="item.quantity + 'x'">
                            </p>
                            {{-- Remove cart item button --}}
                            <button type="button" @click="remove()"
                                class="text-neutral-500 hover:text-black dark:hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 stroke-neutral-500 dark:stroke-neutral-400 group-hover:stroke-black dark:group-hover:stroke-white"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M18 6l-12 12" />
                                    <path d="M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
                <div class="flex justify-end">
                    <div class="px-4 py-2 text-sm font-medium text-black dark:text-white">
                        <p
                            x-text="'Total: $' + Object.values(cart).reduce((total, item) => total + (item.price * item.quantity), 0).toFixed(2)">
                        </p>
                    </div>
                </div>
                {{-- <form method="POST" action="{{ route('dashboard.shop.checkout') }}">
                    @csrf --}}
                <div class="pt-4 border-t border-neutral-300 dark:border-neutral-700">
                    {{-- <button type="submit" class="w-full flex justify-center px-4 py-2 text-sm font-medium text-white bg-black border border-black rounded-md dark:text-black hover:bg-neutral-800 dark:bg-neutral-100 dark:hover:bg-white hover:border-neutral-800 dark:border-neutral-100 dark:hover:border-white disabled:pointer-events-none disabled:opacity-60">
                            {{ __('Checkout') }}
                        </button> --}}
                    <a href="{{ route('dashboard.shop.checkout') }}"
                        class="w-full flex justify-center px-4 py-2 text-sm font-medium text-white bg-black border border-black rounded-md dark:text-black hover:bg-neutral-800 dark:bg-neutral-100 dark:hover:bg-white hover:border-neutral-800 dark:border-neutral-100 dark:hover:border-white disabled:pointer-events-none disabled:opacity-60">
                        {{ __('Checkout') }}
                    </a>
                </div>
                {{-- </form> --}}
            </div>
        </div>
    </div>
</header>
