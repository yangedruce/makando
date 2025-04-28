@php
    $links = [
        [
            'title' => __('Dashboard'),
            'route' => 'dashboard',
            'permissions' => ['dashboard:read'],
        ],
        [
            'title' => __('Shop'),
            'route' => 'dashboard.shop.index',
            'permissions' => ['shop:read'],
        ],
        [
            'title' => __('Orders'),
            'permissions' => ['order:read'],
        ],
        [
            'title' => __('Order History'),
            'route' => 'dashboard.order.index',
            'permissions' => ['order:read'],
        ],
        [
            'title' => __('Upcoming Order'),
            'route' => 'dashboard.order.orderApproval',
            'permissions' => ['order:update'],
        ],
        [
            'title' => __('Managements'),
            'permissions' => ['customer:read', 'restaurant:read', 'restaurant-approval:read','category:read','menu:read','item:read'],
        ],
        // [
        //     'title' => __('Customer'),
        //     'route' => 'dashboard.management.customer.index',
        //     'permissions' => ['customer:read'],
        // ],
        [
            'title' => __('Restaurant'),
            'route' => 'dashboard.management.restaurant.index',
            'permissions' => ['restaurant:read'],
        ],
        [
            'title' => __('Restaurant Category'),
            'route' => 'dashboard.management.category.index',
            'permissions' => ['category:read'],
        ],
        [
            'title' => __('Restaurant Approval'),
            'route' => 'dashboard.management.restaurant-approval.index',
            'permissions' => ['restaurant-approval:read'],
        ],
        [
            'title' => __('Menu'),
            'route' => 'dashboard.management.menu.index',
            'permissions' => ['menu:read'],
        ],
        [
            'title' => __('Menu Type'),
            'route' => 'dashboard.management.type.index',
            'permissions' => ['type:read'],
        ],
        [
            'title' => __('Configurations'),
            'permissions' => ['user:read', 'role:read', 'activity-log:read'],
        ],
        [
            'title' => __('User'),
            'group' => 'dashboard.config.user.*',
            'route' => 'dashboard.config.user.index',
            'permissions' => ['user:read'],
        ],
        [
            'title' => __('Role'),
            'group' => 'dashboard.config.role.*',
            'route' => 'dashboard.config.role.index',
            'permissions' => ['role:read'],
        ],
        [
            'title' => __('Activity Log'),
            'route' => 'dashboard.config.activity-log.index',
            'permissions' => ['activity-log:read'],
        ],
    ];
@endphp

<nav class="fixed top-0 left-0 z-20 invisible hidden w-screen h-screen lg:z-10 lg:-mt-16 lg:pt-16 lg:sticky lg:visible lg:block lg:w-64 lg:bg-transparent bg-neutral-500/50 lg:shrink-0"
    x-data="{
        isSidebarMenuOpen: false,
        breakpointSize: 1024,
        isClickOutside(event) {
            if (!event.target.closest(`#sidebar-menu-content`)) {
                this.isSidebarMenuOpen = false;
            }
        },
        focusables() {
            // All focusable element types...
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
            return [...$el.querySelectorAll(selector)]
                // All non-disabled elements...
                .filter(el => !el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1 },
    }" x-init="$watch('isSidebarMenuOpen', isSidebarMenuOpen => {
        if (isSidebarMenuOpen) {
            $el.setAttribute('tabindex', 1);
            $el.focus();
            setTimeout(() => {
                $el.removeAttribute('tabindex');
            }, 100);
        }
    })" @open-sidebar-menu.window="isSidebarMenuOpen = true"
    @resize.window="if(window.innerWidth >= breakpointSize) isSidebarMenuOpen = false"
    @keydown.escape.window="isSidebarMenuOpen = false" @keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    @keydown.shift.tab.prevent="prevFocusable().focus()" :class="{ 'hidden invisible': !isSidebarMenuOpen }"
    @click="if(window.innerWidth < breakpointSize) isClickOutside(event)">

    <div id="sidebar-menu-content"
        class="fixed top-0 left-0 h-full px-4 overflow-y-auto bg-white border-r shadow sm:px-6 lg:px-8 lg:border-0 border-neutral-200 dark:border-neutral-800 lg:sticky w-72 lg:w-64 lg:bg-transparent lg:dark:bg-transparent lg:shadow-none dark:bg-neutral-800">

        <!-- Logo -->
        <x-link href="{{ route('dashboard') }}" class="inline-block mt-4 sm:mt-6 lg:hidden">
            <span class="text-lg font-bold text-black dark:text-white">{{ config('app.name', 'Makando') }}</span>
        </x-link>

        <!-- Sidebar menu close button -->
        <x-button style="icon" class="absolute right-2 sm:right-4 top-2 sm:top-4 group lg:hidden"
            aria-label="Close sidebar menu." @click="isSidebarMenuOpen = false">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 stroke-neutral-500 dark:stroke-neutral-400 group-hover:stroke-black dark:group-hover:stroke-white"
                width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M18 6l-12 12" />
                <path d="M6 6l12 12" />
            </svg>
        </x-button>

        <!-- Sidebar menu link -->
        <ul class="mt-6 space-y-1 lg:pt-10">
            @foreach ($links as $index => $link)
                @hasPermissions($link['permissions'] ?? null)
                    <li class="relative">
                        @if (isset($link['route']))
                            @if (isset($link['group']))
                                <x-sidebar-link href="{{ route($link['route']) }}"
                                    :active="request()->routeIs($link['route']) || request()->routeIs($link['group'])">{{ $link['title'] }}</x-sidebar-link>
                            @else
                                <x-sidebar-link href="{{ route($link['route']) }}"
                                    :active="request()->routeIs($link['route'])">{{ $link['title'] }}</x-sidebar-link>
                            @endif
                        @else
                            <p class='px-2 pt-6 text-base font-semibold uppercase text-neutral-400'>
                                {{ $link['title'] }}</p>
                        @endif

                        @if (isset($link['create']))
                            <x-link class="absolute top-0 right-0 z-10" style="icon-primary"
                                href="{{ route($link['create']) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                            </x-link>
                        @endif
                    </li>
                @endhasPermissions
            @endforeach
        </ul>
    </div>
</nav>
