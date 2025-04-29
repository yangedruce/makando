@php
    $title = 'Customer';
    $subtitle = 'View all customers';
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
            @if (auth()->user()->hasRole('admin'))
                <div
                    class="flex flex-col items-end justify-end w-full gap-4 lg:items-center sm:flex-row sm:items-center">
                    <x-link href="{{ route('dashboard.management.customer.create') }}" style="primary" class="sm:order-2">
                        {{ __('Add new customer') }}
                    </x-link>
                </div>
            @endif
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
                                    {{ __('Email') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Phone No') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Address') }}
                                </th>
                                <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ __('Status') }}
                                </th>
                                <th class="px-4 pr-12 text-sm text-right text-neutral-800 dark:text-neutral-200">
                                    {{ __('Action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                            @if (count($customers) > 0)
                                @foreach ($customers as $index => $customer)
                                    <tr>
                                        <td
                                            class="px-4 py-3 text-sm text-left capitalize text-neutral-800 dark:text-neutral-200">
                                            {{ ++$index }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            <x-link style="no-hover"
                                                href="{{ route('dashboard.management.customer.show', $customer->id) }}">{{ $customer->user->name ? $customer->user->name : '-' }}</x-link>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            {{ $customer->user->email ? $customer->user->email : '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            {{ $customer->phone_no ? $customer->phone_no : '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            {{ $customer->address ? $customer->address : '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                            {{ $customer->status ? $customer->status : '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                            <div class="flex items-center justify-end gap-2">
                                                <x-link
                                                    href="{{ route('dashboard.management.customer.show', $customer->id) }}">{{ __('View') }}</x-link>

                                                @if (auth()->user()->hasRole('admin'))
                                                    <x-link
                                                        href="{{ route('dashboard.management.customer.edit', $customer->id) }}">{{ __('Edit') }}</x-link>

                                                    <form id="delete-form-{{ $customer->id }}" method="post"
                                                        class="hidden"
                                                        action="{{ route('dashboard.management.customer.destroy', $customer->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                    </form>

                                                    <x-button style="link" x-data
                                                        @click="
                                                    $dispatch('open-modal', 'confirm-delete');
                                                    id='{{ $customer->id }}';
                                                    name='{{ $customer->user->name }}';
                                                ">{{ __('Delete') }}</x-button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6"
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

        <x-paginator :data="$customers"></x-paginator>

        @include('dashboard.management.customer.partials.delete-form')
    </div>
</x-layouts.dashboard>
