@php
    $title = 'Role';
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

        <form id="delete-form-{{ $role->id }}" method="post" class="hidden"
            action="{{ route('dashboard.config.role.destroy', $role->id) }}">
            @csrf
            @method('delete')
        </form>

        <x-card>
            <div class="max-w-xl space-y-8">
                <div class="space-y-1">
                    <x-subtitle>
                        {{ __('Role Information') }}
                    </x-subtitle>
                </div>
                <div class="space-y-4">
                    <div>
                        <x-text><strong>Name:</strong></x-text>
                        <x-text>{{ $role->name }}</x-text>
                    </div>
                    <x-text><strong>Permissions:</strong></x-text>
                    @foreach ($permissions->submodules() as $submodule => $permissions)
                        <div class="space-y-2">
                            <x-text class="capitalize"><strong>{{ $submodule }}</strong></x-text>
                            @foreach ($permissions as $permission)
                                    <div class="grid grid-cols-3">
                                        <div class="flex items-center gap-4">
                                            @php
                                                $hasPermission = in_array($permission->name, $role->permissions->pluck('name')->toArray());
                                            @endphp
                                            @if ($hasPermission)
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M5 12l5 5l10 -10" />
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-red-600 dark:text-red-400"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M18 6l-12 12" />
                                                    <path d="M6 6l12 12" />
                                                </svg>
                                            @endif
                                            <x-text>{{ $permission->name }}</x-text>
                                        </div>

                                        <div class="col-span-2">
                                            <x-text>{{ $permission->description }}</x-text>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                        <x-hr></x-hr>
                    @endforeach
                </div>
            </div>
            
            <div class="flex items-center justify-between gap-2 mt-8">
                @empty($role->trashed())
                    <x-link href="{{ route('dashboard.config.role.index') }}" style="outline">{{ __('Back') }}</x-link>
                    <div class="flex items-center gap-2">
                        @if ($role->is_editable || $role->is_editable === null)
                            <x-link href="{{ route('dashboard.config.role.edit', $role->id) }}" style="primary">{{ __('Edit') }}</x-link>
                        @endif

                        @if ($role->is_deletable || $role->is_deletable === null)
                            <x-button style="danger" x-data
                                @click="
                                    $dispatch('open-modal', 'confirm-delete');
                                    id='{{ $role->id }}';
                                    name='{{ $role->name }}';
                                ">{{ __('Delete') }}</x-button>
                        @endif
                    </div>
                @else
                    <x-link href="{{ route('dashboard.config.activity-log.index') }}" style="outline">{{ __('Back') }}</x-link>
                @endempty
            </div>
        </x-card>

    @include('dashboard.config.role.partials.delete-form')
    </div>

    <x-record-log :logs="$recordLogs"></x-record-log>
</x-layouts.dashboard>
