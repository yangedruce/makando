@php
    $title = 'Restaurant';
    $subtitle = 'Add new restaurant';
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
            <form method="post" action="{{ route('dashboard.management.restaurant.store') }}" x-data="{
                validateForm() {
                    $el.reportValidity();
                    if ($el.checkValidity()) {
                        $el.submit();
                    }
                },
            }">
                @csrf
                @method('post')

                <div class="max-w-xl space-y-4">
                    <div class="space-y-2">
                        <x-label for="name">{{ __('Name') }}</x-label>
                        <x-input type="text" id="name" name="name" value="{{ old('name') }}"
                            placeholder="{{ __('Enter restaurant name') }}" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="description">{{ __('Description') }}</x-label>
                        <x-input type="text" id="description" name="description" value="{{ old('description') }}"
                            placeholder="Enter restaurant description" autofocus></x-input>
                        <x-input-error :messages="$errors->get('description')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="address">{{ __('Address') }}</x-label>
                        <x-input type="text" id="address" name="address" value="{{ old('address') }}"
                            placeholder="{{ __('Enter restaurant address') }}" />
                        <x-input-error :messages="$errors->get('address')" />
                    </div>
                    @if (auth()->user()->hasRole('admin'))
                        <div class="space-y-2">
                            <x-label for="user_id">{{ __('Manager') }}</x-label>
                            <x-input-select id="user_id" name="user_id">
                                <option value="">Select Manager</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </x-input-select>
                            <x-input-error :messages="$errors->get('user_id')" />
                        </div>
                    @endif
                    <div class="space-y-2">
                        <x-label for="categories">{{ __('Categories') }}</x-label>
                        <div class="flex flex-wrap gap-4">
                            @foreach ($categories as $index => $category)
                                <label for="category-id-{{ $index }}"
                                    class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                    <input id="category-id-{{ $index }}" type="checkbox" name="categories[]"
                                        value="{{ $category->id }}" class="accent-neutral-800 dark:accent-neutral-200">
                                    <span>{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('categories')" />
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
