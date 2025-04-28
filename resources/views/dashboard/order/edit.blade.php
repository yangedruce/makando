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

    $allStatuses = [
        'New',
        'Proceeding',
        'Pending',
        'Completed',
        'Cancelled',
    ];
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
                        <x-input id="user_name" name="user_name" value="{{ $order->user->name }}" readonly />
                        <input type="hidden" name="user_id" value="{{ $order->user_id }}" />
                        <x-input-error :messages="$errors->get('user_id')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="restaurant_name">{{ __('Restaurant') }}</x-label>
                        <x-input id="restaurant_name" name="restaurant_name" value="{{ $order->restaurant->name }}"
                            readonly />
                        <input type="hidden" name="restaurant_id" value="{{ $order->restaurant_id }}" />
                        <x-input-error :messages="$errors->get('restaurant_id')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="status">{{ __('Status') }}</x-label>
                        <div class="flex items-center gap-8">
                            @foreach ($allStatuses as $status)
                                <div class="flex items-center gap-4">
                                    <label class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                        <input
                                            id="status-{{ strtolower($status) }}"
                                            type="radio"
                                            name="status"
                                            value="{{ $status }}"
                                            class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                            {{ $currentStatus === $status ? 'checked' : '' }}
                                            {{ !in_array($status, $statusOptions[$currentStatus]) && $currentStatus !== $status ? 'disabled' : '' }}
                                        />
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
                            value="{{ $order->total_price }}" placeholder="{{ __('Enter total price') }}" />
                        <x-input-error :messages="$errors->get('total_price')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="payment_status">{{ __('Payment Status') }}</x-label>
                        <div class="flex items-center gap-8">
                            <div class="flex items-center gap-4">
                                <label
                                    class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                    <input id="payment-status-paid" type="radio" name="payment_status" value="Paid"
                                        class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                        @if ($order->payment_status === 'Paid') checked @endif />
                                    <span>{{ __('Paid') }}</span>
                                </label>
                            </div>
                            <div class="flex items-center gap-4">
                                <label
                                    class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                    <input id="payment-status-unpaid" type="radio" name="payment_status"
                                        value="Unpaid"
                                        class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                        @if ($order->payment_status === 'Unpaid') checked @endif />
                                    <span>{{ __('Unpaid') }}</span>
                                </label>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('payment_status')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="transaction_id">{{ __('Transaction ID') }}</x-label>
                        <x-input id="transaction_id" name="transaction_id" value="{{ $order->transaction_id }}"
                            placeholder="{{ __('Enter transaction ID') }}" />
                        <x-input-error :messages="$errors->get('transaction_id')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="points">{{ __('Points') }}</x-label>
                        <x-input type="number" id="points" name="points" value="{{ $order->points }}"
                            placeholder="{{ __('Enter points') }}" />
                        <x-input-error :messages="$errors->get('points')" />
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
