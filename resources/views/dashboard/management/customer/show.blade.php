@php
    $title = 'Customer';
    $subtitle = 'View customer detail';
@endphp

<x-layouts.dashboard>
    <x-slot:title>
        {{ $title }}
    </x-slot>
    <x-slot:subtitle>
        {{ $subtitle }}
    </x-slot>

    <div x-data="{ id: null, name: null }">

        <form id="delete-form-{{ $customer->id }}" method="post" class="hidden"
            action="{{ route('dashboard.management.customer.destroy', $customer->id) }}">
            @csrf
            @method('delete')
        </form>

        <x-card>
            <div class="max-w-xl space-y-8">
                <div class="space-y-1">
                    <x-subtitle>
                        {{ __('Customer Information') }}
                    </x-subtitle>
                </div>
                <div class="space-y-4">
                    <div>
                        <x-text><strong>Name:</strong></x-text>
                        <x-text>{{ $customer->user->name ? $customer->user->name : '-' }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Email:</strong></x-text>
                        <x-text>{{ $customer->user->email ? $customer->user->email : '-' }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Phone No:</strong></x-text>
                        <x-text>{{ $customer->phone_no ? $customer->phone_no : '-' }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Address:</strong></x-text>
                        <x-text>{{ $customer->address ? $customer->address : '-' }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Status:</strong></x-text>
                        <x-text>{{ $customer->status ? $customer->status : '-' }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Total Points:</strong></x-text>
                        <x-text>{{ $customer->total_points ? $customer->total_points : '-' }}</x-text>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between gap-2 mt-8">
                <x-link href="{{ route('dashboard.management.customer.index') }}"
                    style="outline">{{ __('Back') }}</x-link>
                <div class="flex items-center gap-2">
                    @if (auth()->user()->hasRole('admin'))
                        <x-link href="{{ route('dashboard.management.customer.edit', $customer->id) }}"
                            style="primary">{{ __('Edit') }}</x-link>
                    @endif
                    {{-- @if (auth()->user()->hasRole('admin'))
                        <x-button style="danger" x-data
                            @click="
                            $dispatch('open-modal', 'confirm-delete');
                            id='{{ $customer->id }}';
                            name='{{ $customer->name }}';
                        ">{{ __('Delete') }}</x-button>
                    @endif --}}
                </div>
            </div>
        </x-card>

        {{-- @include('dashboard.management.customer.partials.delete-form') --}}
    </div>
</x-layouts.dashboard>
