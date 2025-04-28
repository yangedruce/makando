@php
    $title = 'Restaurant';
    $subtitle = 'View restaurant detail';
@endphp

<x-layouts.dashboard>
    <x-slot:title>
        {{ $title }}
    </x-slot>
    <x-slot:subtitle>
        {{ $subtitle }}
    </x-slot>

    <div x-data="{ id: null, name: null }">

        <form id="delete-form-{{ $restaurant->id }}" method="post" class="hidden"
            action="{{ route('dashboard.management.restaurant.destroy', $restaurant->id) }}">
            @csrf
            @method('delete')
        </form>

        <x-card>
            <div class="max-w-xl space-y-8">
                <div class="space-y-1">
                    <x-subtitle>
                        {{ __('Restaurant Information') }}
                    </x-subtitle>
                </div>
                <div class="space-y-4">
                    <div>
                        <x-text><strong>Name:</strong></x-text>
                        <x-text>{{ $restaurant->name ? $restaurant->name : '-' }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Description:</strong></x-text>
                        <x-text>{{ $restaurant->description ? $restaurant->description : '-' }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Address:</strong></x-text>
                        <x-text>{{ $restaurant->address ? $restaurant->address : '-' }}</x-text>
                    </div>
                    <div>
                        <x-text class="mb-1"><strong>Status:</strong></x-text>
                        <x-text>
                            @if ($restaurant->status === 'Inactive')
                                @if ($restaurant->is_inactive)
                                    <span class="bg-red-200 text-red-800 dark:text-red-800 rounded-full py-1 px-3 text-xs font-semibold">Inactive (7+ days)</span>
                                @else
                                    <span class="bg-yellow-200 text-yellow-800 dark:text-yellow-800 rounded-full py-1 px-3 text-xs font-semibold">Inactive (Less than 7 days)</span>
                                @endif
                            @elseif ($restaurant->status === 'Pending')
                                <span class="bg-yellow-200 text-yellow-800 dark:text-yellow-800 rounded-full py-1 px-3 text-xs font-semibold">Pending Approval</span>
                            @elseif ($restaurant->status === 'Banned')
                                <span class="bg-red-200 text-red-800 dark:text-red-800 rounded-full py-1 px-3 text-xs font-semibold">Banned</span>
                            @else
                                <span class="bg-green-200 text-green-800 dark:text-green-800 rounded-full py-1 px-3 text-xs font-semibold">Active</span>
                            @endif
                        </x-text>
                    </div>                    
                    <div>
                        <x-text><strong>Restaurant Availability:</strong></x-text>
                        <x-text>{{ $restaurant->is_opened ? __('Open') : __('Closed') }}</x-text>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between gap-2 mt-8">
                <x-link href="{{ route('dashboard.management.restaurant.index') }}"
                    style="outline">{{ __('Back') }}</x-link>
                <div class="flex items-center gap-2">
                    <x-link href="{{ route('dashboard.management.restaurant.edit', $restaurant->id) }}"
                        style="primary">{{ __('Edit') }}</x-link>
                    <x-button style="danger" x-data
                        @click="
                            $dispatch('open-modal', 'confirm-delete');
                            id='{{ $restaurant->id }}';
                            name='{{ $restaurant->name }}';
                        ">{{ __('Delete') }}</x-button>
                </div>
            </div>
        </x-card>

        @include('dashboard.management.restaurant.partials.delete-form')
    </div>
</x-layouts.dashboard>
