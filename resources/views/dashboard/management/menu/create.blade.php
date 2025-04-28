@php
    $title = 'Menu';
    $subtitle = 'Add new menu';
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
                    {{ __('Menu Information') }}
                </x-subtitle>
            </div>
            <form method="post" action="{{ route('dashboard.management.menu.store') }}" enctype="multipart/form-data" x-data="{
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
                        <x-label for="name">{{ __('Name') }}</x-label>
                        <x-input id="name" name="name" value="{{ old('name') }}"
                            placeholder="{{ __('Enter menu name') }}" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="restaurant_id">{{ __('Restaurant') }}</x-label>
                        <x-input-select id="restaurant_id" name="restaurant_id">
                            <option value="">{{ __('Select a restaurant') }}</option>
                            @foreach ($restaurants as $restaurant)
                                <option value="{{ $restaurant->id }}" @selected(old('restaurant_id') == $restaurant->id)>
                                    {{ $restaurant->name }}
                                </option>
                            @endforeach
                        </x-input-select>
                        <x-input-error :messages="$errors->get('restaurant_id')" />
                    </div>  
                    <div class="space-y-2">
                        <x-label for="price">{{ __('Price') }}</x-label>
                        <x-input type="number" step="0.01" id="price" name="price" value="{{ old('price') }}"
                            placeholder="{{ __('Enter menu price') }}" />
                        <x-input-error :messages="$errors->get('price')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="description">{{ __('Menu description') }}</x-label>
                        <x-input type="text" id="description" name="description" value="{{ old('description') }}"
                            placeholder="Enter menu description" autofocus></x-input>
                        <x-input-error :messages="$errors->get('description')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="image">{{ __('Image') }}</x-label>
                        <x-input type="file" id="image" name="image" accept="image/*" />
                        <x-input-error :messages="$errors->get('image')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="type_id">{{ __('Type') }}</x-label>
                        <x-input-select id="type_id" name="type_id">
                            <option value="">{{ __('Select a type') }}</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" @selected(old('type_id') == $type->id)>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </x-input-select>
                        <x-input-error :messages="$errors->get('type_id')" />
                    </div>  
                    <div class="space-y-2">
                        <x-label for="is_available">{{ __('Is Available') }}</x-label>
                        <div class="flex items-center gap-8">
                            <label
                                class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                <input type="radio" name="is_available" value="1"
                                    class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none">
                                <span>{{ __('Yes') }}</span>
                            </label>
                            <label
                                class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                <input type="radio" name="is_available" value="0"
                                    class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none">
                                <span>{{ __('No') }}</span>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('is_available')" />
                    </div>
                </div>
                <div class="flex items-center justify-between gap-2 mt-8">
                    <x-link href="{{ route('dashboard.management.menu.index') }}" style="outline">{{ __('Back') }}</x-link>
                    <x-button @click="validateForm()">{{ __('Save') }}</x-button>
                </div>
            </form>
        </div>
    </x-card>

</x-layouts.dashboard>
