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

<body class="relative min-h-screen antialiased bg-white dark:bg-neutral-950">
    <main>
        <div class="max-w-lg px-4 py-16 mx-auto sm:py-24 lg:py-32 sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <img src="{{ asset('img/makando-logo.png') }}" alt="Makando Logo" class="w-44 h-auto flex justify-center items-center mx-auto mb-8" />
                <x-card>
                    {{ $slot }}
                </x-card>
            </div>
        </div>
    </main>
    @include('layouts.partials.footer')
</body>

</html>
