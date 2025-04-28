@php
    $title = 'Order';
    $subtitle = 'Add new order';
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
            <form method="post" action="{{ route('dashboard.order.store') }}" x-data="{
                validateForm() {
                    $el.reportValidity();
                    if ($el.checkValidity()) {
                        $el.submit();
                    }
                },
            }">
                @csrf

                <div class="max-w-xl space-y-4">
                    <div class="space-y-2">
                        <x-label for="user_id">{{ __('Customer') }}</x-label>
                        <x-input-select id="user_id" name="user_id">
                            <option value="">{{ __('Select Customer') }}</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </x-input-select>
                        <x-input-error :messages="$errors->get('user_id')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="restaurant_id">{{ __('Restaurant') }}</x-label>
                        <x-input-select id="restaurant_id" name="restaurant_id">
                            <option value="">{{ __('Select Restaurant') }}</option>
                            @foreach ($restaurants as $restaurant)
                                <option value="{{ $restaurant->id }}" @selected(old('restaurant_id') == $restaurant->id)>
                                    {{ $restaurant->name }}
                                </option>
                            @endforeach
                        </x-input-select>
                        <x-input-error :messages="$errors->get('restaurant_id')" />
                    </div>
                    <input type="hidden" name="status" value="New">
                    <div class="space-y-2">
                        <x-label for="type">{{ __('Type') }}</x-label>
                        <div class="flex items-center gap-8">
                            <div class="flex items-center gap-4">
                                <label
                                    class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                    <input id="type-pickup" type="radio" name="type" value="Pickup"
                                        class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                        @if (old('type') === 'Pickup') checked @endif />
                                    <span>{{ __('Pickup') }}</span>
                                </label>
                            </div>
                            <div class="flex items-center gap-4">
                                <label
                                    class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                    <input id="type-delivery" type="radio" name="type" value="Delivery"
                                        class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                        @if (old('type') === 'Delivery') checked @endif />
                                    <span>{{ __('Delivery') }}</span>
                                </label>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('type')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="total_price">{{ __('Total Price') }}</x-label>
                        <x-input type="number" step="0.01" id="total_price" name="total_price"
                            value="{{ old('total_price') }}" placeholder="{{ __('Enter total price') }}" />
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
                                        @if (old('payment_status') === 'Paid') checked @endif />
                                    <span>{{ __('Paid') }}</span>
                                </label>
                            </div>
                            <div class="flex items-center gap-4">
                                <label
                                    class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                    <input id="payment-status-unpaid" type="radio" name="payment_status"
                                        value="Unpaid"
                                        class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                        @if (old('payment_status') === 'Unpaid') checked @endif />
                                    <span>{{ __('Unpaid') }}</span>
                                </label>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('payment_status')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="points">{{ __('Points') }}</x-label>
                        <x-input type="number" id="points" name="points" min="0" value="{{ old('points', $order->points ?? 0) }}"
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
