@php
    $title = 'Order';
    $subtitle = 'View all orders';
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
                <x-link href="{{ route('dashboard.order.create') }}" style="primary" class="sm:order-2">
                    {{ __('Add new order') }}
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
                                    {{ __('Customer') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Restaurant') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Status') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Type') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Payment Status') }}
                                </th>
                                <th class="px-4 pr-12 text-sm text-right text-neutral-800 dark:text-neutral-200">
                                    {{ __('Action') }}
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
                                                href="{{ route('dashboard.order.show', $order->id) }}">{{ $order->customer->name ? $order->customer->name : '-' }}</x-link>
                                        </td>
                                        <td
                                            class="px-4 py-3 text-sm text-left capitalize text-neutral-800 dark:text-neutral-200">
                                            {{ $order->restaurant->name ? $order->restaurant->name : '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left capitalize">
                                            @if ($order->status === 'New')
                                                <span class="bg-gray-200 text-gray-800 dark:text-gray-200 rounded-full py-1 px-3 text-xs font-semibold">New</span>
                                            @elseif ($order->status === 'Proceeding')
                                                <span class="bg-blue-200 text-blue-800 dark:text-blue-200 rounded-full py-1 px-3 text-xs font-semibold">Proceeding</span>
                                            @elseif ($order->status === 'Pending')
                                                <span class="bg-yellow-200 text-yellow-800 dark:text-yellow-200 rounded-full py-1 px-3 text-xs font-semibold">Pending</span>
                                            @elseif ($order->status === 'Completed')
                                                <span class="bg-green-200 text-green-800 dark:text-green-200 rounded-full py-1 px-3 text-xs font-semibold">Completed</span>
                                            @elseif ($order->status === 'Cancelled')
                                                <span class="bg-red-200 text-red-800 dark:text-red-200 rounded-full py-1 px-3 text-xs font-semibold">Cancelled</span>
                                            @else
                                                <span class="bg-neutral-200 text-neutral-800 dark:text-neutral-200 rounded-full py-1 px-3 text-xs font-semibold">
                                                    {{ $order->status ? $order->status : '-' }}
                                                </span>
                                            @endif
                                        </td>                                        
                                        <td
                                            class="px-4 py-3 text-sm text-left capitalize text-neutral-800 dark:text-neutral-200">
                                            {{ $order->type ? $order->type : '-' }}
                                        </td>
                                        <td
                                            class="px-4 py-3 text-sm text-left capitalize text-neutral-800 dark:text-neutral-200">
                                            {{ $order->payment_status ? $order->payment_status : '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                            <div class="flex items-center justify-end gap-2">
                                                <x-link
                                                    href="{{ route('dashboard.order.show', $order->id) }}">{{ __('View') }}</x-link>
                                                @if (!in_array($order->status, ['Completed', 'Cancelled']))
                                                    <x-link
                                                        href="{{ route('dashboard.order.edit', $order->id) }}">{{ __('Edit') }}</x-link>
                                                @endif
                                                <form id="delete-form-{{ $order->id }}" method="post"
                                                    class="hidden"
                                                    action="{{ route('dashboard.order.destroy', $order->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                </form>

                                                <x-button style="link" x-data
                                                    @click="
                                                    $dispatch('open-modal', 'confirm-delete');
                                                    id='{{ $order->id }}';
                                                    name='{{ $order->customer->name }}';
                                                ">{{ __('Delete') }}</x-button>
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

        @include('dashboard.order.partials.delete-form')
    </div>
</x-layouts.dashboard>
