@php
    $title = 'Menu';
    $subtitle = 'Update menu details';
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
            <form method="post" action="{{ route('dashboard.management.menu.update', $menu->id) }}" enctype="multipart/form-data" x-data="{
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
                        <x-input id="name" name="name" value="{{ $menu->name }}"
                            placeholder="{{ __('Enter menu name') }}" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="restaurant_id">{{ __('Restaurant') }}</x-label>
                        <x-input-select id="restaurant_id" name="restaurant_id">
                            <option value="">{{ __('Select a restaurant') }}</option>
                            @foreach ($restaurants as $restaurant)
                                <option value="{{ $restaurant->id }}"
                                    @selected($menu->restaurant_id === $restaurant->id)>
                                    {{ $restaurant->name }}
                                </option>
                            @endforeach
                        </x-input-select>
                        <x-input-error :messages="$errors->get('restaurant_id')" />
                    </div>   
                    <div class="space-y-2">
                        <x-label for="price">{{ __('Price') }}</x-label>
                        <x-input type="number" step="0.01" id="price" name="price" value="{{ $menu->price }}"
                            placeholder="{{ __('Enter menu price') }}" />
                        <x-input-error :messages="$errors->get('price')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="description">{{ __('Menu description') }}</x-label>
                        <x-input type="text" id="description" name="description" value="{{ $menu->description }}"
                            placeholder="Enter menu description" autofocus></x-input>
                        <x-input-error :messages="$errors->get('description')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="type_id">{{ __('Type') }}</x-label>
                        <x-input-select id="type_id" name="type_id">
                            <option value="">{{ __('Select a type') }}</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" @selected($menu->type_id == $type->id)>
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
                                    class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                    @if ($menu->is_available) checked @endif>
                                <span>{{ __('Yes') }}</span>
                            </label>
                            <label
                                class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                <input type="radio" name="is_available" value="0"
                                    class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                    @if (!$menu->is_available) checked @endif>
                                <span>{{ __('No') }}</span>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('is_available')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="image">{{ __('Image') }}</x-label>
                        <x-input type="file" id="image" name="image" accept="image/*" />
                        <x-input-error :messages="$errors->get('image')" />
                        @isset($menu->image)
                            <div class="mt-2">
                                <img src="{{ asset($menu->image->path) }}" alt="Menu Image"
                                    alt="Menu Image" class="w-32 h-32 object-cover rounded-lg">
                            </div>
                        @endisset
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
