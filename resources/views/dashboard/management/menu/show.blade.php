@php
    $title = 'Menu';
    $subtitle = 'View menu detail';
@endphp

<x-layouts.dashboard>
    <x-slot:title>
        {{ $title }}
    </x-slot>
    <x-slot:subtitle>
        {{ $subtitle }}
    </x-slot>

    <div x-data="{ id: null, name: null }">

        <form id="delete-form-{{ $menu->id }}" method="post" class="hidden"
            action="{{ route('dashboard.management.menu.destroy', $menu->id) }}">
            @csrf
            @method('delete')
        </form>

        <x-card>
            <div class="max-w-xl space-y-8">
                <div class="space-y-1">
                    <x-subtitle>
                        {{ __('Menu Information') }}
                    </x-subtitle>
                </div>
                <div class="space-y-4">
                    <div>
                        <x-text><strong>Name:</strong></x-text>
                        <x-text>{{ $menu->name ? $menu->name :'-' }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Restaurant:</strong></x-text>
                        <x-text>{{ $menu->restaurant->name ? $menu->restaurant->name : '-' }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Price:</strong></x-text>
                        <x-text>${{ number_format($menu->price, 2) }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Description:</strong></x-text>
                        <x-text>{{ $menu->description ? $menu->description : '-' }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Type:</strong></x-text>
                        <x-text>{{ $menu->type->name ? $menu->type->name : '-'  }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Is Available:</strong></x-text>
                        <x-text>{{ $menu->is_available ? __('Yes') : __('No') }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Image:</strong></x-text>
                        @isset($menu->image)
                            <img src="{{ asset($menu->image->path) }}" alt="Menu Image"
                                class="mt-1 w-32 h-32 object-cover rounded-lg">
                        @else
                            <x-text>{{ __('No Image') }}</x-text>
                        @endisset
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between gap-2 mt-8">
                <x-link href="{{ route('dashboard.management.menu.index') }}" style="outline">{{ __('Back') }}</x-link>
                <div class="flex items-center gap-2">
                    <x-link href="{{ route('dashboard.management.menu.edit', $menu->id) }}"
                        style="primary">{{ __('Edit') }}</x-link>
                    <x-button style="danger" x-data
                        @click="
                            $dispatch('open-modal', 'confirm-delete');
                            id='{{ $menu->id }}';
                            name='{{ $menu->name }}';
                        ">{{ __('Delete') }}</x-button>
                </div>
            </div>
        </x-card>

        @include('dashboard.management.menu.partials.delete-form')
    </div>
</x-layouts.dashboard>
