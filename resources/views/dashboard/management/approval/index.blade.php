@php
    $title = 'Restaurant Approval';
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
                                    {{ __('Status') }}
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
                                            {{ $restaurant->name ? $restaurant->name : '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            <div class="space-y-2">
                                                <div class="flex items-center gap-8">
                                                    <label
                                                        class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                                        <input type="radio" name="status-{{ $restaurant->id }}"
                                                            value="Active"
                                                            class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                                            @if ($restaurant->status === config('constant.status.restaurant.active')) checked @endif
                                                            @click="
                                                                $dispatch('open-modal', 'confirm-approval');
                                                                id='{{ $restaurant->id }}';
                                                                name='{{ $restaurant->name }}';
                                                            ">
                                                        <span>{{ __('Approved') }}</span>
                                                    </label>
                                                    <label
                                                        class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                                        <input type="radio" name="status-{{ $restaurant->id }}"
                                                            value="Banned"
                                                            class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                                            @if ($restaurant->status === config('constant.status.restaurant.banned')) checked @endif
                                                            @click="
                                                                $dispatch('open-modal', 'confirm-approval');
                                                                id='{{ $restaurant->id }}';
                                                                name='{{ $restaurant->name }}';
                                                            ">
                                                        <span>{{ __('Disapproved') }}</span>
                                                    </label>
                                                </div>
                                                <x-input-error :messages="$errors->get('status')" />
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

        @include('dashboard.management.approval.partials.modal-form')
    </div>
</x-layouts.dashboard>
