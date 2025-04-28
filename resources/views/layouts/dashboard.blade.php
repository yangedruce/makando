<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Metadata -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#ffffff" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts.partials.metadata')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('layouts.partials.header-scripts')

    <title>
        @isset($title)
            {!! "$title | " !!}
        @endisset {{ config('app.name', 'Makando') }}
    </title>
</head>

<body x-data="{
    cartOpen: false,
    cart: {},
    restaurant_id: null,
    addToCart(id, image, name, price) {
        axios.post('/cart/add', {
                id: id,
                image: image,
                name: name,
                price: price
            }, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector(`meta[name='csrf-token']`).getAttribute('content')
                }
            })
            .then(response => {
                this.cart = JSON.parse(response.data.cart.items)
                this.restaurant_id = response.data.cart?.restaurant_id ?? null;
                {{-- this.cartLength = Object.keys(this.cart).length; --}}
                {{-- console.log(Object.keys(this.cart).length) --}}
            })
            .catch(error => {
                {{-- if (error.response && error.response.data.errors) {
                this.message = Object.values(error.response.data.errors).join(', ');
            } else {
                this.message = 'Something went wrong.';
            } --}}
            });
    },
    removeFromCart(id) {
        axios.post('/cart/remove', {
                id: id,
            }, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector(`meta[name='csrf-token']`).getAttribute('content')
                }
            })
            .then(response => {
                this.cart = JSON.parse(response.data.cart.items)
                this.restaurant_id = response.data.cart?.restaurant_id ?? null;
            })
            .catch(error => {
                {{-- if (error.response && error.response.data.errors) {
                this.message = Object.values(error.response.data.errors).join(', ');
            } else {
                this.message = 'Something went wrong.';
            } --}}
            });
    },
    clearFromCart(id) {
        axios.post('/cart/clear', {
                id: id,
            }, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector(`meta[name='csrf-token']`).getAttribute('content')
                }
            })
            .then(response => {
                this.cart = JSON.parse(response.data.cart.items)
                this.restaurant_id = response.data.cart?.restaurant_id ?? null;
            })
            .catch(error => {
                {{-- if (error.response && error.response.data.errors) {
                this.message = Object.values(error.response.data.errors).join(', ');
            } else {
                this.message = 'Something went wrong.';
            } --}}
            });
    },
    async initCart() {
        try {
            const id = window.location.pathname.includes('/shop/show/') ?
                window.location.pathname.split('/shop/show/')[1] :
                null;
            const response = await axios.post('/cart/latest', { restaurant_id: id });
            this.cart = response.data.cart?.items ?? {};
            this.restaurant_id = response.data.cart?.restaurant_id ?? null;
        } catch (error) {
            console.error(error);
        }
    },
}"
    x-init="initCart()"class="relative min-h-screen antialiased bg-white dark:bg-neutral-950">

    {{-- Navbar --}}
    @include('layouts.partials.dashboard-navbar')
    <div class="flex w-full max-w-screen-xl mx-auto">

        @if (auth()->user()->role === 'Customer' && (empty(auth()->user()->phone) || empty(auth()->user()->address)))
            {{-- Do NOT show sidebar if customer has incomplete profile --}}
        @elseif (auth()->user()->role === 'Manager' && !auth()->user()->restaurant)
            {{-- Do NOT show sidebar if manager has no restaurant --}}
        @else
            @include('layouts.partials.dashboard-sidebar')
        @endif

        <div class="relative overflow-x-auto flex-auto w-full min-h-[calc(100vh-64px)] px-4 py-16 sm:px-6 lg:px-8">
            <div class="mb-8">
                @isset($title)
                    <div class="mb-2">
                        <x-title>{{ $title }}</x-title>
                    </div>
                @endisset
                @isset($subtitle)
                    <div>
                        <x-subtitle>{{ $subtitle }}</x-subtitle>
                    </div>
                @endisset
            </div>

            @if (session('alert') !== null)
                <div class="relative px-4 mt-8 border rounded-md sm:px-4 bg-neutral-100 dark:bg-neutral-700 border-neutral-200 dark:border-neutral-800"
                    x-data="{ isOpen: true }" x-init="setTimeout(() => {
                        isOpen = false;
                        window.location.reload();
                    }, 3000)" x-show="isOpen" x-transition>

                    <x-button class="absolute top-2 right-2" style="icon" aria-label="Close alert."
                        @click="isOpen = false">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 stroke-neutral-500 dark:stroke-neutral-400 group-hover:stroke-black dark:group-hover:stroke-white"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                    </x-button>

                    <div class="py-4 pr-2">
                        <x-text>{{ session('alert') }}</x-text>
                    </div>
                </div>
            @endif

            <main class="mt-8">
                {{ $slot }}
            </main>
            @include('layouts.partials.footer')
        </div>
    </div>
</body>

</html>
