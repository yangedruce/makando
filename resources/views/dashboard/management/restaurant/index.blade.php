@php
    $title = 'Restaurant';
    $subtitle = 'View all restaurants';
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
                <x-link href="{{ route('dashboard.management.restaurant.create') }}" style="primary" class="sm:order-2">
                    {{ __('Add new restaurant') }}
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
                                    {{ __('Name') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Address') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Status') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Restaurant Availability') }}
                                </th>
                                <th class="px-4 pr-12 text-sm text-right text-neutral-800 dark:text-neutral-200">
                                    {{ __('Action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                            @if (count($restaurants) > 0)
                                @foreach ($restaurants as $index => $restaurant)
                                    <tr>
                                        <td
                                            class="px-4 py-3 text-sm text-left capitalize text-neutral-800 dark:text-neutral-200">
                                            {{ ++$index }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            <x-link style="no-hover"
                                                href="{{ route('dashboard.management.restaurant.show', $restaurant->id) }}">{{ $restaurant->name }}</x-link>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            {{ $restaurant->address }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            @if ($restaurant->status === 'Inactive')
                                                @if ($restaurant->is_inactive)
                                                    <span class="bg-red-200 text-red-800 dark:text-red-800 rounded-full py-1 px-3 text-xs font-semibold">Inactive (7+ days)</span>
                                                @else
                                                    <span class="bg-yellow-200 text-yellow-800 dark:text-yellow-800 rounded-full py-1 px-3 text-xs font-semibold">Inactive (Less than 7 days)</span>
                                                @endif
                                            @elseif ($restaurant->status === 'Pending')
                                                <span class="bg-yellow-200 text-yellow-800 dark:text-yellow-800 rounded-full py-1 px-3 text-xs font-semibold">Pending Approval</span>
                                            @elseif ($restaurant->status === 'Banned')
                                                <span class="bg-red-200 text-red-800 dark:text-red-800 rounded-full py-1 px-3 text-xs font-semibold">Banned</span>
                                            @else
                                                <span class="bg-green-200 text-green-800 dark:text-green-800 rounded-full py-1 px-3 text-xs font-semibold">Active</span>
                                            @endif
                                        </td>                                   
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            {{ $restaurant->is_opened ? __('Open') : __('Closed') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                            <div class="flex items-center justify-end gap-2">
                                                <x-link
                                                    href="{{ route('dashboard.management.restaurant.show', $restaurant->id) }}">{{ __('View') }}</x-link>
                                                <x-link
                                                    href="{{ route('dashboard.management.restaurant.edit', $restaurant->id) }}">{{ __('Edit') }}</x-link>

                                                <form id="delete-form-{{ $restaurant->id }}" method="post"
                                                    class="hidden"
                                                    action="{{ route('dashboard.management.restaurant.destroy', $restaurant->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                </form>

                                                <x-button style="link" x-data
                                                    @click="
                                                    $dispatch('open-modal', 'confirm-delete');
                                                    id='{{ $restaurant->id }}';
                                                    name='{{ $restaurant->name }}';
                                                ">{{ __('Delete') }}</x-button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6"
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

        <x-paginator :data="$restaurants"></x-paginator>

        @include('dashboard.management.restaurant.partials.delete-form')
    </div>
</x-layouts.dashboard>
