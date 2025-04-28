@php
    $title = 'Upcoming Order';
    $subtitle = 'View all upcoming orders';
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
                                    {{ __('Customer') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Restaurant') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Status') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                            @if (count($orders) > 0)
                                @foreach ($orders as $index => $order)
                                    <tr>
                                        <td
                                            class="px-4 py-3 text-sm text-left capitalize text-neutral-800 dark:text-neutral-200">
                                            {{ ++$index }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            <x-link style="no-hover"
                                                href="{{ route('dashboard.order.show', $order->id) }}">{{ $order->customer->name ?? __('N/A') }}</x-link>
                                        </td>
                                        <td
                                            class="px-4 py-3 text-sm text-left capitalize text-neutral-800 dark:text-neutral-200">
                                            {{ $order->restaurant->name ?? __('N/A') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            <div class="space-y-2">
                                                <div class="flex items-center gap-8">
                                                    <label
                                                        class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                                        <input type="radio" name="status-{{ $order->id }}"
                                                            value="Proceeding"
                                                            class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                                            @if ($order->status === config('constant.status.order.proceeding')) checked @endif
                                                            @click="
                                                                $dispatch('open-modal', 'confirm-approval');
                                                                id='{{ $order->id }}';
                                                                name='{{ $order->customer->name }}';
                                                            ">
                                                        <span>{{ __('Proceeding') }}</span>
                                                    </label>
                                                    <label
                                                        class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                                        <input type="radio" name="status-{{ $order->id }}"
                                                            value="Cancelled"
                                                            class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                                            @if ($order->status === config('constant.status.order.cancelled')) checked @endif
                                                            @click="
                                                                $dispatch('open-modal', 'confirm-approval');
                                                                id='{{ $order->id }}';
                                                                name='{{ $order->customer->name }}';
                                                            ">
                                                        <span>{{ __('Cancelled') }}</span>
                                                    </label>
                                                </div>
                                                <x-input-error :messages="$errors->get('status')" />
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5"
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

        <x-paginator :data="$orders"></x-paginator>

        @include('dashboard.order.partials.modal-form')
    </div>
</x-layouts.dashboard>
