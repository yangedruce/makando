@php
    $title = 'Restaurant Category';
    $subtitle = 'Update category details';
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
                    {{ __('Category Information') }}
                </x-subtitle>
            </div>
            <form method="post" action="{{ route('dashboard.management.category.update', $category->id) }}" x-data="{
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
                        <x-input id="name" name="name" value="{{ $category->name }}"
                            placeholder="{{ __('Enter category name') }}" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="user_id">{{ __('Manager') }}</x-label>
                        <x-input-select id="user_id" name="user_id">
                            <option value="">Select Manager</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $category->user_id === $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </x-input-select>
                        <x-input-error :messages="$errors->get('user_id')" />
                    </div>
                </div>
                <div class="flex items-center justify-between gap-2 mt-8">
                    <x-link href="{{ route('dashboard.management.category.index') }}" style="outline">{{ __('Back') }}</x-link>
                    <x-button @click="validateForm()">{{ __('Save') }}</x-button>
                </div>
            </form>
        </div>
    </x-card>

</x-layouts.dashboard>
