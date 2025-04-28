@php
    $title = 'User';
    $subtitle = 'View record detail';
@endphp

<x-layouts.dashboard>
    <x-slot:title>
        {{ $title }}
    </x-slot>
    <x-slot:subtitle>
        {{ $subtitle }}
    </x-slot>

    <div x-data="{ id: null, name: null }">

        <form id="delete-form-{{ $user->id }}" method="post" class="hidden"
            action="{{ route('dashboard.config.user.destroy', $user->id) }}">
            @csrf
            @method('delete')
        </form>

        <x-card>
            <div class="max-w-xl space-y-8">
                <div class="space-y-1">
                    <x-subtitle>
                        {{ __('User Information') }}
                    </x-subtitle>
                </div>
                <div class="space-y-4">
                    <div>
                        <x-text><strong>Name:</strong></x-text>
                        <x-text>{{ $user->name }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Email:</strong></x-text>
                        <x-text>{{ $user->email }}</x-text>
                    </div>
                    <div>
                        <x-text><strong>Role:</strong></x-text>
                        @foreach($user->roles as $role)
                            <x-text>{{ $role->name }}</x-text>
                        @endforeach
                    </div>
                </div>
            </div>

                <div class="flex items-center justify-between gap-2 mt-8">
                    @empty($role->trashed())
                        <x-link href="{{ route('dashboard.config.user.index') }}" style="outline">{{ __('Back') }}</x-link>
                        <div class="flex items-center gap-2">
                            @if ($user->is_editable || $user->is_editable === null)
                                <x-link href="{{ route('dashboard.config.user.edit', $user->id) }}" style="primary">{{ __('Edit') }}</x-link>
                            @endif

                            @if ($user->is_deletable || $user->is_deletable === null)
                                <x-button style="danger" x-data
                                    @click="
                                        $dispatch('open-modal', 'confirm-delete');
                                        id='{{ $user->id }}';
                                        name='{{ $user->name }}';
                                    ">{{ __('Delete') }}</x-button>
                            @endif
                        </div>
                    @else
                        <x-link href="{{ route('dashboard.config.activity-log.index') }}" style="outline">{{ __('Back') }}</x-link>
                    @endempty
                </div>

        </x-card>

    @include('dashboard.config.user.partials.delete-form')
    </div>

    <x-record-log :logs="$recordLogs"></x-record-log>
</x-layouts.dashboard>
