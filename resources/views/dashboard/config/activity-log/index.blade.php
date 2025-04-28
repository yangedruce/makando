@php
    $title = 'Activity Log';
    $subtitle = 'View all records';
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
            <div class="flex flex-col items-end w-full gap-4 lg:items-center sm:flex-row sm:items-center">
                <form id="search-form" method="get" action="{{ route('dashboard.config.user.search') }}" class="space-y-4">
                    <div class="flex flex-col items-end justify-between w-full gap-4 lg:items-center sm:flex-row sm:items-center">
                        {{-- Search bar --}}
                        <div class="flex w-full gap-2 sm:max-w-sm sm:order-1">
                            <x-input type="text" id="keyword" name="keyword" value="{{ optional($request)->keyword }}"
                                placeholder="{{ __('Search activity logs') }}"></x-input>
                            <x-button type="submit" style="icon-outline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                    <path d="M21 21l-6 -6" />
                                </svg>
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
            <div
                class="overflow-hidden border divide-y rounded-md border-neutral-200 dark:border-neutral-800 divide-neutral-200 dark:divide-neutral-800">

                <div class="overflow-x-auto">
                    <table class="w-full divide-y whitespace-nowrap divide-neutral-200 dark:divide-neutral-800">
                        <thead class=" bg-neutral-50 dark:bg-neutral-900">
                            <tr>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('No' )}}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Activity' )}}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Action' )}}
                                </th>
                                <th class="px-4 py-3 text-sm text-center text-neutral-800 dark:text-neutral-200">
                                    {{ __('Time' )}}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                            @if (count($activityLogs) > 0)
                                @foreach ($activityLogs as $index => $activityLog)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-left capitalize text-neutral-800 dark:text-neutral-200">
                                            {{ ++$index }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            @empty ($activityLog->record_route)
                                                {{ $activityLog->activity }}
                                            @else
                                                <x-link style="no-hover" href="{{ $activityLog->record_route }}">{{ $activityLog->activity }}</x-link>
                                            @endempty
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            @empty($activityLog->user)
                                                {{ __('System') }}
                                            @else
                                                {{ $activityLog->user->email }}
                                            @endempty
                                        </td>
                                        <td class="px-4 py-3 text-sm text-center text-neutral-800 dark:text-neutral-200">
                                            {{ $activityLog->created_at }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4"
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

        <x-paginator :data="$activityLogs"></x-paginator>
    </div>
</x-layouts.dashboard>
