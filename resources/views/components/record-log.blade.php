@props(['logs'])

<x-subtitle class="mt-8">{{ __('Record Log') }}</x-subtitle>
    
    <div class="mt-4 overflow-hidden border divide-y rounded-md border-neutral-200 dark:border-neutral-800 divide-neutral-200 dark:divide-neutral-800">
        <div class="overflow-x-auto">
            <table class="w-full divide-y whitespace-nowrap divide-neutral-200 dark:divide-neutral-800">
                <thead class=" bg-neutral-50 dark:bg-neutral-900">
                    <tr>
                        <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                            {{ __('Action') }}
                        </th>
                        <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                            {{ __('Description') }}
                        </th>
                        <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                            {{ __('Data') }}
                        </th>
                        <th class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                            {{ __('Executor') }}
                        </th>
                        <th class="px-4 py-3 text-sm text-center text-neutral-800 dark:text-neutral-200">
                            {{ __('Time') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                    @if (count($logs) > 0)
                        @foreach ($logs as $log)
                            <tr>
                                <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ $log->action }}
                                </td>
                                <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    {{ $log->description }}
                                </td>
                                <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    @empty($log->data)
                                        {{ __('[]') }}
                                    @else
                                        {{ $log->data }}
                                    @endempty
                                </td>
                                <td class="px-4 py-3 text-sm text-left text-neutral-800 dark:text-neutral-200">
                                    @empty($log->user)
                                        {{ __('System') }}
                                    @else
                                        {{ $log->user->email }}
                                    @endempty
                                </td>
                                <td class="px-4 py-3 text-sm text-center text-neutral-800 dark:text-neutral-200">
                                    {{ $log->created_at }}
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

    <x-paginator :data="$logs"></x-paginator>