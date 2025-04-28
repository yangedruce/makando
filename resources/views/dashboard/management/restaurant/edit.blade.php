@php
    $title = 'Restaurant';
    $subtitle = 'Update restaurant details';
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
                    {{ __('Restaurant Information') }}
                </x-subtitle>
            </div>
            <form method="post" action="{{ route('dashboard.management.restaurant.update', $restaurant->id) }}"
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
                        <x-input id="name" name="name" value="{{ $restaurant->name }}"
                            placeholder="{{ __('Enter restaurant name') }}" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="description">{{ __('Description') }}</x-label>
                        <x-input type="text" id="description" name="description"
                            value="{{ $restaurant->description }}" placeholder="Enter restaurant description"
                            autofocus></x-input>
                        <x-input-error :messages="$errors->get('description')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="address">{{ __('Address') }}</x-label>
                        <x-input id="address" name="address" value="{{ $restaurant->address }}"
                            placeholder="{{ __('Enter restaurant address') }}" />
                        <x-input-error :messages="$errors->get('address')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="status">{{ __('Status') }}</x-label>
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-4 xl:gap-8">
                            @foreach (config('constant.status.restaurant') as $key => $value)
                                @if (!($restaurant->status !== 'Pending' && $value === 'Pending'))
                                    <label
                                        class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                        <input type="radio" name="status" value="{{ $value }}"
                                            class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                            @if ($restaurant->status === $value) checked @endif>
                                        <span>{{ __($value) }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('status')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="is_opened">{{ __('Restaurant Availability') }}</x-label>
                        <div class="flex items-center gap-8">
                            <label
                                class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                <input type="radio" name="is_opened" value="1"
                                    class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                    @if ($restaurant->is_opened) checked @endif>
                                <span>{{ __('Open') }}</span>
                            </label>
                            <label
                                class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                <input type="radio" name="is_opened" value="0"
                                    class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                    @if (!$restaurant->is_opened) checked @endif>
                                <span>{{ __('Closed') }}</span>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('is_opened')" />
                    </div>
                </div>
                <div class="flex items-center justify-between gap-2 mt-8">
                    <x-link href="{{ route('dashboard.management.restaurant.index') }}"
                        style="outline">{{ __('Back') }}</x-link>
                    <x-button @click="validateForm()">{{ __('Save') }}</x-button>
                </div>
            </form>
        </div>
    </x-card>

</x-layouts.dashboard>
