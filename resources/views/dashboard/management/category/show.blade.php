@php
    $title = 'Restaurant Category';
    $subtitle = 'View category detail';
@endphp

<x-layouts.dashboard>
    <x-slot:title>
        {{ $title }}
    </x-slot>
    <x-slot:subtitle>
        {{ $subtitle }}
    </x-slot>

    <div x-data="{ id: null, name: null }">

        <form id="delete-form-{{ $category->id }}" method="post" class="hidden"
            action="{{ route('dashboard.management.category.destroy', $category->id) }}">
            @csrf
            @method('delete')
        </form>

        <x-card>
            <div class="max-w-xl space-y-8">
                <div class="space-y-1">
                    <x-subtitle>
                        {{ __('Category Information') }}
                    </x-subtitle>
                </div>
                <div class="space-y-4">
                    <div>
                        <x-text><strong>Name:</strong></x-text>
                        <x-text>{{ $category->name ? $category->name : '-' }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Manager email:</strong></x-text>
                        <x-text>{{ $category->manager->email ? $category->manager->email : '-' }}</x-text>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between gap-2 mt-8">
                <x-link href="{{ route('dashboard.management.category.index') }}" style="outline">{{ __('Back') }}</x-link>
                <div class="flex items-center gap-2">
                    <x-link href="{{ route('dashboard.management.category.edit', $category->id) }}"
                        style="primary">{{ __('Edit') }}</x-link>
                    <x-button style="danger" x-data
                        @click="
                            $dispatch('open-modal', 'confirm-delete');
                            id='{{ $category->id }}';
                            name='{{ $category->name }}';
                        ">{{ __('Delete') }}</x-button>
                </div>
            </div>
        </x-card>

        @include('dashboard.management.category.partials.delete-form')
    </div>
</x-layouts.dashboard>
