@php
    $title = 'Dashboard';
@endphp

<x-layouts.dashboard>
    <x-slot:title>
        {{ $title }}
    </x-slot>

    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3" x-data="{
            analytics: [
            @if ($role === 'Admin' || $role === 'Restaurant Manager')
            {
                icon: `<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6 stroke-black dark:stroke-white' viewBox='0 0 24 24' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M3 12m0 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z' /><path d='M9 8m0 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z' /><path d='M15 4m0 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z' /><path d='M4 20l14 0' /></svg>`,
                title: 'Overall Sales',
                value: '${{ number_format($overallSales, 2) }}'
            },
            {
                icon: `<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6 stroke-black dark:stroke-white' viewBox='0 0 24 24' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0' /><path d='M14.8 9a2 2 0 0 0-1.8-1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1-1.8-1' /><path d='M12 7v10' /></svg>`,
                title: 'Today Sales',
                value: '${{ number_format($todaySales, 2) }}'
            },
            {
                icon: `<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6 stroke-black dark:stroke-white' viewBox='0 0 24 24' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M3 12m0 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z' /><path d='M9 8m0 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z' /><path d='M15 4m0 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z' /><path d='M4 20l14 0' /></svg>`,
                title: 'Overall Orders',
                value: '{{ $overallOrders }}'
            },
            {
                icon: `<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6 stroke-black dark:stroke-white' viewBox='0 0 24 24' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0-4 0' /><path d='M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0-4 0' /><path d='M17 17h-11v-14h-2' /><path d='M6 5l14 1l-1 7h-13' /></svg>`,
                title: 'Today Orders',
                value: '{{ $todayOrders }}'
            },
            {
                icon: `<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6 stroke-black dark:stroke-white' viewBox='0 0 24 24' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M9.615 20h-2.615a2 2 0 0 1-2-2v-12a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8' /><path d='M14 19l2 2l4-4' /><path d='M9 8h4' /><path d='M9 12h2' /></svg>`,
                title: 'Pending Orders',
                value: '{{ $pendingOrders }}'
            },
            {
                icon: `<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6 stroke-black dark:stroke-white' viewBox='0 0 24 24' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M3 12m0 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z' /><path d='M9 8m0 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z' /><path d='M15 4m0 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z' /><path d='M4 20l14 0' /></svg>`,
                title: 'Overall Customers',
                value: '{{ $overallCustomers }}'
            },
            {
                icon: `<svg  xmlns='http://www.w3.org/2000/svg'  width='24'  height='24'  viewBox='0 0 24 24'  fill='none'  stroke='currentColor'  stroke-width='1.5'  stroke-linecap='round'  stroke-linejoin='round'  class='w-6 h-6 stroke-black dark:stroke-white icon icon-tabler icons-tabler-outline icon-tabler-user'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0' /><path d='M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2' /></svg>`,
                title: 'Today Customers',
                value: '{{ $todayCustomers }}'
            },
            {
                icon: `<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6 stroke-black dark:stroke-white' viewBox='0 0 24 24' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M3 12m0 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z' /><path d='M9 8m0 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z' /><path d='M15 4m0 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z' /><path d='M4 20l14 0' /></svg>`,
                title: 'Overall Restaurants',
                value: '{{ $overallRestaurants }}'
            },
            {
                icon: `<svg  xmlns='http://www.w3.org/2000/svg'  width='24'  height='24'  viewBox='0 0 24 24'  fill='none'  stroke='currentColor'  stroke-width='1.5'  stroke-linecap='round'  stroke-linejoin='round'  class='w-6 h-6 stroke-black dark:stroke-white icon icon-tabler icons-tabler-outline icon-tabler-building-store'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M3 21l18 0' /><path d='M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4' /><path d='M5 21l0 -10.15' /><path d='M19 21l0 -10.15' /><path d='M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4' /></svg>`,
                title: 'Today Restaurants',
                value: '{{ $todayRestaurants }}'
            },
            {
                icon: `<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6 stroke-black dark:stroke-white' viewBox='0 0 24 24' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M9.615 20h-2.615a2 2 0 0 1-2-2v-12a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8' /><path d='M14 19l2 2l4-4' /><path d='M9 8h4' /><path d='M9 12h2' /></svg>`,
                title: 'Pending Restaurants',
                value: '{{ $pendingRestaurants }}'
            },
            @elseif ($role === 'Customer')
            {
                icon: `<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6 stroke-black dark:stroke-white' viewBox='0 0 24 24' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0' /><path d='M14.8 9a2 2 0 0 0-1.8-1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1-1.8-1' /><path d='M12 7v10' /></svg>`,
                title: 'Total Spending',
                value: '${{ number_format($totalSpending, 2) }}'
            },
            {
                icon: `<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6 stroke-black dark:stroke-white' viewBox='0 0 24 24' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M3 12m0 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z' /><path d='M9 8m0 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z' /><path d='M15 4m0 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z' /><path d='M4 20l14 0' /></svg>`,
                title: 'Total Points',
                value: '{{ $totalPoints }}'
            },
            {
                icon: `<svg xmlns='http://www.w3.org/2000/svg' class='w-6 h-6 stroke-black dark:stroke-white' viewBox='0 0 24 24' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M3 12m0 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z' /><path d='M9 8m0 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z' /><path d='M15 4m0 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z' /><path d='M4 20l14 0' /></svg>`,
                title: 'Total Orders',
                value: '{{ $totalOrders }}'
            },
            @endif
        ],
    }">
        <template x-for="analytic in analytics" hidden>
            <div
                class="flex gap-4 p-4 bg-white border rounded-md border-neutral-200 dark:border-neutral-800 dark:bg-neutral-800">
                <div class="self-center p-4 rounded-md bg-neutral-200 dark:bg-neutral-700" x-html="analytic.icon"></div>
                <div class="flex-1 space-y-1 text-right shrink-0">
                    <p class="text-base text-neutral-700 dark:text-neutral-300"><strong x-text="analytic.title"></strong>
                    </p>
                    <p class="text-lg font-bold text-black sm:text-xl lg:text-2xl dark:text-white"
                        x-text="analytic.value"></p>
                </div>
            </div>
        </template>
    </section>
    </div>
</x-layouts.dashboard>
