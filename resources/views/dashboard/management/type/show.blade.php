@php
    $title = 'Menu Type';
    $subtitle = 'View type detail';
@endphp

<x-layouts.dashboard>
    <x-slot:title>
        {{ $title }}
    </x-slot>
    <x-slot:subtitle>
        {{ $subtitle }}
    </x-slot>

    <div x-data="{ id: null, name: null }">

        <form id="delete-form-{{ $type->id }}" method="post" class="hidden"
            action="{{ route('dashboard.management.type.destroy', $type->id) }}">
            @csrf
            @method('delete')
        </form>

        <x-card>
            <div class="max-w-xl space-y-8">
                <div class="space-y-1">
                    <x-subtitle>
                        {{ __('Type Information') }}
                    </x-subtitle>
                </div>
                <div class="space-y-4">
                    <div>
                        <x-text><strong>Name:</strong></x-text>
                        <x-text>{{ $type->name }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Restaurant:</strong></x-text>
                        <x-text>{{ $type->restaurant->name ?? 'N/A' }}</x-text>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between gap-2 mt-8">
                <x-link href="{{ route('dashboard.management.type.index') }}" style="outline">{{ __('Back') }}</x-link>
                <div class="flex items-center gap-2">
                    <x-link href="{{ route('dashboard.management.type.edit', $type->id) }}"
                        style="primary">{{ __('Edit') }}</x-link>
                    <x-button style="danger" x-data
                        @click="
                            $dispatch('open-modal', 'confirm-delete');
                            id='{{ $type->id }}';
                            name='{{ $type->name }}';
                        ">{{ __('Delete') }}</x-button>
                </div>
            </div>
        </x-card>

        @include('dashboard.management.type.partials.delete-form')
    </div>
</x-layouts.dashboard>
