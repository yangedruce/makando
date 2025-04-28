@php
    $title = 'Menu';
    $subtitle = 'View all menus';
@endphp

<x-layouts.dashboard>
    <x-slot:title>
        {{ $title }}
    </x-slot>
    <x-slot:subtitle>
        {{ $subtitle }}
    </x-slot>

    <div x-data="{ id: null, name: null }">
        <div class="space-y-4">
            <div class="flex flex-col items-end justify-end w-full gap-4 lg:items-center sm:flex-row sm:items-center">
                <x-link href="{{ route('dashboard.management.menu.create') }}" style="primary" class="sm:order-2">
                    {{ __('Add new menu') }}
                </x-link>
            </div>
            <div
                class="overflow-hidden border divide-y rounded-md border-neutral-200 dark:border-neutral-800 divide-neutral-200 dark:divide-neutral-800">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y whitespace-nowrap divide-neutral-200 dark:divide-neutral-800">
                        <thead class=" bg-neutral-50 dark:bg-neutral-900">
                            <tr>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('No') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Image') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Name') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Restaurant') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Price') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Type') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Is Available') }}
                                </th>
                                <th class="px-4 pr-12 text-sm text-right text-neutral-800 dark:text-neutral-200">
                                    {{ __('Action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                            @if (count($menus) > 0)
                                @foreach ($menus as $index => $menu)
                                    <tr>
                                        <td
                                            class="px-4 py-3 text-sm text-left capitalize text-neutral-800 dark:text-neutral-200">
                                            {{ ++$index }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            @isset($menu->image->path)  
                                                <img src="{{ asset($menu->image->path) }}"
                                                    alt="Menu Image" class="w-16 h-16 object-cover rounded-lg">
                                            @else
                                                {{ __('No Image') }}
                                            @endisset
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            <x-link style="no-hover"
                                                href="{{ route('dashboard.management.menu.show', $menu->id) }}">{{ $menu->name }}</x-link>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            {{ $menu->restaurant->name ?? __('N/A') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            ${{ number_format($menu->price, 2) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            {{ $menu->type?->name ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            {{ $menu->is_available ? __('Yes') : __('No') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                            <div class="flex items-center justify-end gap-2">
                                                <x-link
                                                    href="{{ route('dashboard.management.menu.show', $menu->id) }}">{{ __('View') }}</x-link>
                                                <x-link
                                                    href="{{ route('dashboard.management.menu.edit', $menu->id) }}">{{ __('Edit') }}</x-link>

                                                <form id="delete-form-{{ $menu->id }}" method="post"
                                                    class="hidden"
                                                    action="{{ route('dashboard.management.menu.destroy', $menu->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                </form>

                                                <x-button style="link" x-data
                                                    @click="
                                                    $dispatch('open-modal', 'confirm-delete');
                                                    id='{{ $menu->id }}';
                                                    name='{{ $menu->name }}';
                                                ">{{ __('Delete') }}</x-button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4"
                                        class="px-4 py-3 text-sm text-center text-neutral-800 dark:text-neutral-200">
                                        <x-text>{{ __('No data available.') }}</x-text>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <x-paginator :data="$menus"></x-paginator>

        @include('dashboard.management.menu.partials.delete-form')
    </div>
</x-layouts.dashboard>
