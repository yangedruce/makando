@php
    $title = 'User';
    $subtitle = 'View all records';
    $isFilterOpen = false;
    if (!empty($request)) {
        foreach ($request->input() as $key => $input) {
            if ($key != 'keyword') {
                $isFilterOpen = true;
            }
        }
    }
@endphp

<x-layouts.dashboard>
    <x-slot:title>
        {{ $title }}
    </x-slot>
    <x-slot:subtitle>
        {{ $subtitle }}
    </x-slot>

    <div x-data="{ id: null, name: null }">
        <div class="space-y-4">
            <form id="search-form" method="get" action="{{ route('dashboard.config.user.search') }}" class="space-y-4"
                x-data="{
                    isFilterOpen: @js($isFilterOpen),
                    triggerSearchForm() {
                        $el.submit();
                    }
                }">
                <div
                    class="flex flex-col items-end justify-between w-full gap-4 lg:items-center sm:flex-row sm:items-center">
                    {{-- Add new record --}}
                    <x-link href="{{ route('dashboard.config.user.create') }}" style="primary"
                        class="sm:order-2">{{ __('Add new record') }}</x-link>

                    {{-- Search bar --}}
                    <div class="flex w-full gap-2 sm:max-w-sm sm:order-1">
                        <x-input type="text" id="keyword" name="keyword" value="{{ optional($request)->keyword }}"
                            placeholder="{{ __('Search user') }}"></x-input>
                        <x-button type="submit" style="icon-outline">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                <path d="M21 21l-6 -6" />
                            </svg>
                        </x-button>
                        <x-button style="icon-outline" @click="isFilterOpen = !isFilterOpen">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z" />
                            </svg>
                        </x-button>
                    </div>
                </div>

                {{-- Filter --}}
                <div class="hidden px-4 py-3 space-y-2 border rounded-md border-neutral-200 dark:border-neutral-800"
                    :class="{ 'hidden': !isFilterOpen }">
                    <x-text><strong>{{ __('Filter by') }}</strong></x-text>

                    {{-- Role --}}
                    <x-text><strong>{{ __('Role') }}</strong></x-text>
                    <div class="flex gap-2">
                        @foreach ($roles as $index => $role)
                            <label for="role-id-{{ $index }}" class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                <input id="role-id-{{ $index }}" type="checkbox" name="role_id[]" value="{{ $role->id }}" class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                    @if (optional($request)->has('role_id')) 
                                        @foreach ($request->role_id as $roleId)
                                            @if ($role->id == $roleId) checked @endif
                                        @endforeach
                                    @endif
                                    @change="triggerSearchForm()"
                                />
                                <span>{{ $role->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </form>
            <div class="overflow-hidden border divide-y rounded-md border-neutral-200 dark:border-neutral-800 divide-neutral-200 dark:divide-neutral-800">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y whitespace-nowrap divide-neutral-200 dark:divide-neutral-800">
                        <thead class=" bg-neutral-50 dark:bg-neutral-900">
                            <tr>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('No' )}}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Name' )}}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Email' )}}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Role' )}}
                                </th>
                                <th class="px-4 pr-12 text-sm text-right text-neutral-800 dark:text-neutral-200">
                                    {{ __('Action' )}}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                            @if (count($users) > 0)
                                @foreach ($users as $index => $user)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-left capitalize text-neutral-800 dark:text-neutral-200">
                                            {{ ++$index }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            <x-link style="no-hover" href="{{ route('dashboard.config.user.show', $user->id) }}">{{ $user->name }}</x-link>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left capitalize text-neutral-800 dark:text-neutral-200">
                                            @foreach($user->roles as $role)
                                                <span class="block">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td class="px-4 py-3 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                            <div class="flex items-center justify-end gap-2">
                                                <x-link
                                                    href="{{ route('dashboard.config.user.show', $user->id) }}">{{ __('View') }}</x-link>
                                                <x-link
                                                    href="{{ route('dashboard.config.user.edit', $user->id) }}">{{ __('Edit') }}</x-link>

                                                <form id="delete-form-{{ $user->id }}" method="post"
                                                    class="hidden"
                                                    action="{{ route('dashboard.config.user.destroy', $user->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                </form>

                                                <x-button style="link" x-data
                                                    @click="
                                                    $dispatch('open-modal', 'confirm-delete');
                                                    id='{{ $user->id }}';
                                                    name='{{ $user->name }}';
                                                ">{{ __('Delete') }}</x-button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5"
                                        class="px-4 py-3 text-sm text-center text-neutral-800 dark:text-neutral-200">
                                        <x-text>{{ __('No data available.') }}</x-text>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <x-paginator :data="$users"></x-paginator>

        @include('dashboard.config.user.partials.delete-form')
    </div>
</x-layouts.dashboard>
