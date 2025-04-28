@php
    $title = 'Order';
    $subtitle = 'View order detail';
@endphp

<x-layouts.dashboard>
    <x-slot:title>
        {{ $title }}
    </x-slot>
    <x-slot:subtitle>
        {{ $subtitle }}
    </x-slot>

    <div x-data="{ id: null, name: null }">

        <form id="delete-form-{{ $order->id }}" method="post" class="hidden"
            action="{{ route('dashboard.order.destroy', $order->id) }}">
            @csrf
            @method('delete')
        </form>

        <x-card>
            <div class="max-w-xl space-y-8">
                <div class="space-y-1">
                    <x-subtitle>
                        {{ __('Order Information') }}
                    </x-subtitle>
                </div>
                <div class="space-y-4">
                    <div>
                        <x-text><strong>Customer:</strong></x-text>
                        <x-text>{{ $order->customer->name ? $order->customer->name : '-' }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Restaurant:</strong></x-text>
                        <x-text>{{ $order->restaurant->name ? $order->restaurant->name : '-' }}</x-text>
                    </div>
                    <div>
                        <x-text class="mb-1"><strong>Status:</strong></x-text>
                        <x-text>
                            @if ($order->status === 'New')
                                <span
                                    class="bg-gray-200 text-gray-800 dark:text-gray-200 rounded-full py-1 px-3 text-xs font-semibold">New</span>
                            @elseif ($order->status === 'Proceeding')
                                <span
                                    class="bg-blue-200 text-blue-800 dark:text-blue-200 rounded-full py-1 px-3 text-xs font-semibold">Proceeding</span>
                            @elseif ($order->status === 'Pending')
                                <span
                                    class="bg-yellow-200 text-yellow-800 dark:text-yellow-200 rounded-full py-1 px-3 text-xs font-semibold">Pending</span>
                            @elseif ($order->status === 'Completed')
                                <span
                                    class="bg-green-200 text-green-800 dark:text-green-200 rounded-full py-1 px-3 text-xs font-semibold">Completed</span>
                            @elseif ($order->status === 'Cancelled')
                                <span
                                    class="bg-red-200 text-red-800 dark:text-red-200 rounded-full py-1 px-3 text-xs font-semibold">Cancelled</span>
                            @else
                                <span
                                    class="bg-neutral-200 text-neutral-800 dark:text-neutral-200 rounded-full py-1 px-3 text-xs font-semibold">
                                    {{ $order->status }}
                                </span>
                            @endif
                        </x-text>
                    </div>
                    <div>
                        <x-text><strong>Type:</strong></x-text>
                        <x-text>{{ ucfirst($order->type ? $order->type : '-') }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Total Price:</strong></x-text>
                        <x-text>${{ number_format($order->total_price ? $order->total_price : '-', 2) }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Payment Status:</strong></x-text>
                        <x-text>{{ $order->payment_status ? $order->payment_status : '-' }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Points:</strong></x-text>
                        <x-text>{{ $order->points ? $order->points : '-' }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Order Items:</strong></x-text>
                        @if ($order->orderItems->count() > 0)
                            @foreach ($order->orderItems as $item)
                                @isset($item->menu->image->path)
                                    <img src="{{ asset($item->menu->image->path) }}" alt="Menu Image"
                                        class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <x-text>{{ __('No Image') }}</x-text>
                                @endisset
                                <x-text>{{ $item->menu->name }} {{ $item->quantity }}x
                                    ${{ $item->menu->price * $item->quantity }}</x-text>
                            @endforeach
                        @else
                            <x-text>{{ __('-') }}</x-text>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between gap-2 mt-8">
                <x-link href="{{ route('dashboard.order.index') }}" style="outline">{{ __('Back') }}</x-link>
                <div class="flex items-center gap-2">
                    @if ((auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Restaurant Manager')) &&
                            !in_array($order->status, ['New', 'Completed', 'Cancelled']))
                        <x-link href="{{ route('dashboard.order.edit', $order->id) }}"
                            style="primary">{{ __('Edit') }}</x-link>
                    @endif

                    <x-button style="danger" x-data
                        @click="
                            $dispatch('open-modal', 'confirm-delete');
                            id='{{ $order->id }}';
                            name='{{ $order->customer->name }}';
                        ">{{ __('Delete') }}</x-button>
                </div>
            </div>
        </x-card>

        @include('dashboard.order.partials.delete-form')
    </div>
</x-layouts.dashboard>
