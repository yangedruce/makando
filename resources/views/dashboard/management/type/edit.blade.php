@php
    $title = 'Menu Type';
    $subtitle = 'Update type details';
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
                    {{ __('Type Information') }}
                </x-subtitle>
            </div>
            <form method="post" action="{{ route('dashboard.management.type.update', $type->id) }}" x-data="{
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
                        <x-input id="name" name="name" value="{{ $type->name }}"
                            placeholder="{{ __('Enter type name') }}" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="restaurant_id">{{ __('Restaurant') }}</x-label>
                        <x-input-select id="restaurant_id" name="restaurant_id">
                            <option value="">{{ __('Select a restaurant') }}</option>
                            @foreach ($restaurants as $restaurant)
                                <option value="{{ $restaurant->id }}"
                                    @selected(old('restaurant_id', $type->restaurant_id) == $restaurant->id)>
                                    {{ $restaurant->name }}
                                </option>
                            @endforeach
                        </x-input-select>
                        <x-input-error :messages="$errors->get('restaurant_id')" />
                    </div>   
                </div>
                <div class="flex items-center justify-between gap-2 mt-8">
                    <x-link href="{{ route('dashboard.management.type.index') }}" style="outline">{{ __('Back') }}</x-link>
                    <x-button @click="validateForm()">{{ __('Save') }}</x-button>
                </div>
            </form>
        </div>
    </x-card>

</x-layouts.dashboard>
