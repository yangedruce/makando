@php
    $title = 'Shop';
    $subtitle = 'View all shops';
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
            <form id="search-form" method="get" action="{{ route('dashboard.shop.index') }}" class="space-y-4"
                x-data="{
                    isFilterOpen: @js($isFilterOpen),
                    triggerSearchForm() {
                        $el.submit();
                    }
                }">
                <div
                    class="flex flex-col items-end justify-between w-full gap-4 lg:items-center sm:flex-row sm:items-center">
                    {{-- Search bar --}}
                    <div class="flex w-full gap-2 sm:max-w-sm sm:order-1">
                        <x-input type="text" id="keyword" name="keyword" value="{{ optional($request)->keyword }}"
                            placeholder="{{ __('Search restaurant') }}"></x-input>
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

                    {{-- Categories --}}
                    <x-text><strong>{{ __('Categories') }}</strong></x-text>
                    <div class="flex gap-2">
                        @foreach ($categories as $index => $category)
                            <label for="category-id-{{ $index }}"
                                class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                <input id="category-id-{{ $index }}" type="checkbox" name="category_id[]"
                                    value="{{ $category->id }}" class="accent-neutral-800 dark:accent-neutral-200"
                                    @if (optional($request)->has('category_id')) @foreach ($request->category_id as $categoryId)
                        @if ($category->id == $categoryId) checked @endif
                                    @endforeach
                        @endif
                        @change="triggerSearchForm()"
                        />
                        <span>{{ $category->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </form>
            <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 mt-12">
                @foreach ($restaurants as $restaurant)
                    <a href="{{ route('dashboard.shop.show', $restaurant->id) }}"
                        class="bg-white border rounded-md border-neutral-200 hover:border-neutral-500 dark:hover:border-neutral-500 dark:border-neutral-800 dark:bg-neutral-800 p-4 flex flex-col items-center space-y-4">
                        <div class="flex flex-col w-full gap-y-4">
                            <div class="flex flex-col">
                                <h3 class="text-lg font-bold text-black dark:text-white">
                                    {{ $restaurant->name ? $restaurant->name : '-' }}</h3>
                                <p class="text-neutral-700 dark:text-neutral-300">
                                    {{ $restaurant->address ? $restaurant->address : '-' }}</p>
                            </div>
                            <p class="text-xs text-neutral-700 dark:text-neutral-300">
                                <span class="font-bold">Categories:</span>
                                @if ($restaurant->categories->count() > 0)
                                    @foreach ($restaurant->categories as $index => $category)
                                        {{ $category->name }}@if ($index < count($restaurant->categories) - 1),@endif
                                    @endforeach
                                @else
                                    <x-text>{{ __('-') }}</x-text>
                                @endif
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>

            <x-paginator :data="$restaurants"></x-paginator>
        </div>
    </div>
</x-layouts.dashboard>
