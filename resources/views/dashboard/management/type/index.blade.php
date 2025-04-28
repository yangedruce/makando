@php
    $title = 'Menu Type';
    $subtitle = 'View all types';
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
            <div class="flex flex-col items-end justify-end w-full gap-4 lg:items-center sm:flex-row sm:items-center">
                <x-link href="{{ route('dashboard.management.type.create') }}" style="primary" class="sm:order-2">
                    {{ __('Add new type') }}
                </x-link>
            </div>
            <div
                class="overflow-hidden border divide-y rounded-md border-neutral-200 dark:border-neutral-800 divide-neutral-200 dark:divide-neutral-800">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y whitespace-nowrap divide-neutral-200 dark:divide-neutral-800">
                        <thead class=" bg-neutral-50 dark:bg-neutral-900">
                            <tr>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('No') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Name') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Restaurant') }}
                                </th>
                                <th class="px-4 pr-12 text-sm text-right text-neutral-800 dark:text-neutral-200">
                                    {{ __('Action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                            @if (count($types) > 0)
                                @foreach ($types as $index => $type)
                                    <tr>
                                        <td
                                            class="px-4 py-3 text-sm text-left capitalize text-neutral-800 dark:text-neutral-200">
                                            {{ ++$index }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            <x-link style="no-hover"
                                                href="{{ route('dashboard.management.type.show', $type->id) }}">{{ $type->name ? $type->name : '-' }}</x-link>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            {{ $type->restaurant->name ? $type->restaurant->name : '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                            <div class="flex items-center justify-end gap-2">
                                                <x-link
                                                    href="{{ route('dashboard.management.type.show', $type->id) }}">{{ __('View') }}</x-link>
                                                <x-link
                                                    href="{{ route('dashboard.management.type.edit', $type->id) }}">{{ __('Edit') }}</x-link>

                                                <form id="delete-form-{{ $type->id }}" method="post"
                                                    class="hidden"
                                                    action="{{ route('dashboard.management.type.destroy', $type->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                </form>

                                                <x-button style="link" x-data
                                                    @click="
                                                    $dispatch('open-modal', 'confirm-delete');
                                                    id='{{ $type->id }}';
                                                    name='{{ $type->name }}';
                                                ">{{ __('Delete') }}</x-button>
                                            </div>
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

        <x-paginator :data="$types"></x-paginator>

        @include('dashboard.management.type.partials.delete-form')
    </div>
</x-layouts.dashboard>
