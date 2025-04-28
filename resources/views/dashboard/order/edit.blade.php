@php
    $title = 'Order';
    $subtitle = 'Update order details';

    $currentStatus = $order->status;

    $statusOptions = [
        'New' => ['Proceeding', 'Pending', 'Completed', 'Cancelled'],
        'Proceeding' => ['Pending', 'Completed', 'Cancelled'],
        'Pending' => ['Completed', 'Cancelled'],
        'Completed' => [],
        'Cancelled' => [],
    ];

    $allStatuses = ['New', 'Proceeding', 'Pending', 'Completed', 'Cancelled'];
@endphp

<x-layouts.dashboard>
    <x-slot:title>
        {{ $title }}
    </x-slot>
    <x-slot:subtitle>
        {{ $subtitle }}
    </x-slot>

    <x-card>
        <div class="space-y-8">
            <div class="space-y-1">
                <x-subtitle>
                    {{ __('Order Information') }}
                </x-subtitle>
            </div>
            <form method="post" action="{{ route('dashboard.order.update', $order->id) }}" x-data="{
                validateForm() {
                    $el.reportValidity();
                    if ($el.checkValidity()) {
                        $el.submit();
                    }
                },
            }">
                @csrf
                @method('patch')

                <div class="max-w-xl space-y-4">
                    <div class="space-y-2">
                        <x-label for="user_name">{{ __('Customer') }}</x-label>
                        <x-input id="user_name" name="user_name" value="{{ $order->user->name }}" readonly disabled />
                        <input type="hidden" name="user_id" value="{{ $order->user_id }}" />
                        <x-input-error :messages="$errors->get('user_id')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="email">{{ __('Email') }}</x-label>
                        <x-input id="email" name="email" value="{{ $order->user->email }}" readonly disabled />
                    </div>
                    <div class="space-y-2">
                        <x-label for="address">{{ __('Address') }}</x-label>
                        <x-input id="address" name="address" value="{{ $order->user->customer->address ?? '-' }}" readonly disabled />
                    </div>
                    <div class="space-y-2">
                        <x-label for="phone_no">{{ __('Phone Number') }}</x-label>
                        <x-input id="phone_no" name="phone_no" value="{{ $order->user->customer->phone_no ?? '-' }}" readonly disabled />
                    </div>
                    <div class="space-y-2">
                        <x-label for="restaurant_name">{{ __('Restaurant') }}</x-label>
                        <x-input id="restaurant_name" name="restaurant_name" value="{{ $order->restaurant->name }}"
                            readonly disabled />
                        <input type="hidden" name="restaurant_id" value="{{ $order->restaurant_id }}" />
                        <x-input-error :messages="$errors->get('restaurant_id')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="status">{{ __('Status') }}</x-label>
                        <div class="flex items-center gap-8">
                            @foreach ($allStatuses as $status)
                                <div class="flex items-center gap-4">
                                    <label
                                        class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                        <input id="status-{{ strtolower($status) }}" type="radio" name="status"
                                            value="{{ $status }}"
                                            class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                            {{ $currentStatus === $status ? 'checked' : '' }}
                                            {{ !in_array($status, $statusOptions[$currentStatus]) && $currentStatus !== $status ? 'disabled' : '' }} />
                                        <span>{{ __($status) }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('status')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="type">{{ __('Type') }}</x-label>
                        <div class="flex items-center gap-8">
                            <div class="flex items-center gap-4">
                                <label
                                    class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                    <input id="type-pickup" type="radio" name="type" value="Pickup"
                                        class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                        @if ($order->type === 'Pickup') checked @endif />
                                    <span>{{ __('Pickup') }}</span>
                                </label>
                            </div>
                            <div class="flex items-center gap-4">
                                <label
                                    class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                    <input id="type-delivery" type="radio" name="type" value="Delivery"
                                        class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                        @if ($order->type === 'Delivery') checked @endif />
                                    <span>{{ __('Delivery') }}</span>
                                </label>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('type')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="total_price">{{ __('Total Price') }}</x-label>
                        <x-input type="number" step="0.01" id="total_price" name="total_price"
                            value="{{ $order->total_price }}" placeholder="{{ __('Enter total price') }}" readonly
                            disabled />
                        <x-input-error :messages="$errors->get('total_price')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="payment_status">{{ __('Payment Status') }}</x-label>
                        <div class="flex items-center gap-8">
                            <div class="flex items-center gap-4">
                                <label
                                    class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                    <input id="payment-status-paid" type="radio" name="payment_status" value="Paid"
                                        class="accent-neutral-800 dark:accent-neutral-200"
                                        @if ($order->payment_status === 'Paid') checked @endif disabled />
                                    <span>{{ __('Paid') }}</span>
                                </label>
                            </div>
                            <div class="flex items-center gap-4">
                                <label
                                    class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                    <input id="payment-status-unpaid" type="radio" name="payment_status"
                                        value="Unpaid" class="accent-neutral-800 dark:accent-neutral-200"
                                        @if ($order->payment_status === 'Unpaid') checked @endif disabled />
                                    <span>{{ __('Unpaid') }}</span>
                                </label>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('payment_status')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="points">{{ __('Points') }}</x-label>
                        <x-input type="number" id="points" name="points" value="{{ $order->points }}" readonly disabled
                            placeholder="{{ __('Enter points') }}" />
                        <x-input-error :messages="$errors->get('points')" />
                    </div>  
                    <div>
                        <x-text><strong>Order Items:</strong></x-text>
                        @if ($order->orderItems->count() > 0)
                            @foreach ($order->orderItems as $item)
                                <div class="p-4 bg-neutral-100 dark:bg-neutral-700 rounded mt-2">
                                    <div class="flex items-center space-x-4 w-full">
                                        @isset($item->menu->image->path)
                                            <img src="{{ asset($item->menu->image->path) }}" alt="Menu Image"
                                                class="w-12 h-12 object-cover rounded" />
                                        @else
                                            <x-text class="text-xs">{{ __('No Image') }}</x-text>
                                        @endisset
                                        <div class="flex flex-col w-full">
                                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-start sm:justify-between w-full sm:gap-4">
                                                <div class="flex flex-col">
                                                    <p class="text-sm font-bold text-black dark:text-white">
                                                        {{ $item->menu->name }}</p>
                                                    <p class="text-sm text-neutral-600 dark:text-neutral-300">
                                                        ${{ number_format($item->menu->price, 2) }}
                                                    </p>
                                                </div>
                                                <div class="flex flex-col text-left md:text-right">
                                                    <p class="text-sm font-medium text-black dark:text-white">
                                                        {{ $item->quantity }}x</p>

                                                    <p
                                                        class="text-sm font-medium text-black dark:text-white">
                                                        <span class="font-bold">Total Price:</span>
                                                        ${{ number_format($item->menu->price * $item->quantity, 2) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <x-text>{{ __('-') }}</x-text>
                        @endif   
                    </div>               
                </div>
                <div class="flex items-center justify-between gap-2 mt-8">
                    <x-link href="{{ route('dashboard.order.index') }}" style="outline">{{ __('Back') }}</x-link>
                    <x-button @click="validateForm()">{{ __('Save') }}</x-button>
                </div>
            </form>
        </div>
    </x-card>

</x-layouts.dashboard>
