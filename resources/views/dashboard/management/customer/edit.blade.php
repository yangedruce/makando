@php
    $title = 'Customer';
    $subtitle = 'Update customer details';
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
                    {{ __('Customer Information') }}
                </x-subtitle>
            </div>
            <form method="post" action="{{ route('dashboard.management.customer.update', $customer->id) }}"
                x-data="{
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
                        <x-label for="name">{{ __('Name') }}</x-label>
                        <x-input id="name" name="name" value="{{ $customer->user->name }}"
                            placeholder="{{ __('Enter customer name') }}" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="email">{{ __('Email') }}</x-label>
                        <x-input id="email" name="email" value="{{ $customer->user->email }}"
                            placeholder="{{ __('Enter customer email') }}" />
                        <x-input-error :messages="$errors->get('email')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="phone_no">{{ __('Phone Number') }}</x-label>
                        <x-input id="phone_no" name="phone_no" value="{{ $customer->phone_no }}"
                            placeholder="{{ __('Enter phone number') }}" />
                        <x-input-error :messages="$errors->get('phone_no')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="address">{{ __('Address') }}</x-label>
                        <x-input id="address" name="address" value="{{ $customer->address }}"
                            placeholder="{{ __('Enter address') }}" />
                        <x-input-error :messages="$errors->get('address')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="status">{{ __('Status') }}</x-label>
                        <div class="flex items-center gap-8">
                            <label
                                class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                <input type="radio" name="status" value="Active"
                                    class="accent-neutral-800 dark:accent-neutral-200" @checked($customer->status === 'Active')>
                                <span>{{ __('Active') }}</span>
                            </label>
                            <label
                                class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                <input type="radio" name="status" value="Inactive"
                                    class="accent-neutral-800 dark:accent-neutral-200" @checked($customer->status === 'Inactive')>
                                <span>{{ __('Inactive') }}</span>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('status')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="total_points">{{ __('Total Points') }}</x-label>
                        <x-input id="total_points" name="total_points" type="number" min="0"
                            value="{{ $customer->total_points }}"
                            placeholder="{{ __('Enter total points') }}" />
                        <x-input-error :messages="$errors->get('total_points')" />
                    </div>
                </div>
                <div class="flex items-center justify-between gap-2 mt-8">
                    <x-link href="{{ route('dashboard.management.customer.index') }}"
                        style="outline">{{ __('Back') }}</x-link>
                    <x-button @click="validateForm()">{{ __('Save') }}</x-button>
                </div>
            </form>
        </div>
    </x-card>

</x-layouts.dashboard>
