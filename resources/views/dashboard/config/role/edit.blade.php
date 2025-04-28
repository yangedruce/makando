@php
    $title = 'Role';
    $subtitle = 'Update record detail';
@endphp

<x-layouts.dashboard>
    <x-slot:title>
        {{ $title }}
    </x-slot>
    <x-slot:subtitle>
        {{ $subtitle }}
    </x-slot>

    <x-card>
        <div class="space-y-8">
            <div class="space-y-1">
                <x-subtitle>
                    {{ __('Role Information') }}
                </x-subtitle>
            </div>
            <form method="post" action="{{ route('dashboard.config.role.update', $role->id) }}"
                x-data="{
                    triggerCheckboxModule(element) {
                            permissionCheckboxes = document.querySelectorAll(`[aria-labelledby='${element.id}']`);
                            permissionCheckboxes.forEach(checkboxElement => {
                                checkboxElement.checked = element.checked;
                            })
                        },
                        triggerCheckboxPermission(element) {
                            moduleCheckbox = document.getElementById(`${element.getAttribute('aria-labelledby')}`);
                            moduleCheckbox.checked = true;
                            permissionCheckboxes = document.querySelectorAll(`[aria-labelledby='${element.getAttribute('aria-labelledby')}']`);
                            permissionCheckboxes.forEach(checkboxElement => {
                                if (!checkboxElement.checked) moduleCheckbox.checked = false;
                            })
                        }
                }">
                @csrf
                @method('patch')

                <div class="max-w-xl space-y-4">
                    <div class="space-y-2">
                        <x-label for="name">{{ __('Role name') }}</x-label>
                        <x-input type="text" id="name" name="name" value="{{ $role->name }}"
                            placeholder="Enter role name" required autofocus></x-input>
                        <x-input-error :messages="$errors->get('name')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="name">{{ __('Role description') }}</x-label>
                        <x-input type="text" id="description" name="description" value="{{ $role->description }}"
                            placeholder="Enter role description" required autofocus></x-input>
                        <x-input-error :messages="$errors->get('description')" />
                    </div>
                    <x-text><strong>Permissions:</strong></x-text>
                    @foreach ($permissions->submodules() as $submodule => $permissions)
                        <div class="space-y-2">
                            <label
                                class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                <input id="{{ $submodule }}" type="checkbox"
                                    name="permission_submodule[]" value="{{ $submodule }}"
                                    class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                    @if (!empty(old('permission_submodule'))) 
                                        @foreach (old('permission_submodule') as $permissionSubmodule)
                                            @if ($permissionSubmodule == $submodule) checked @endif
                                        @endforeach
                                    @endif
                                    x-init="
                                    $el.checked = true;
                                    permissionCheckboxes = document.querySelectorAll(`[aria-labelledby='{{ $submodule }}']`);
                                    permissionCheckboxes.forEach(checkboxElement => {
                                        if (!checkboxElement.checked) $el.checked = false;
                                    })
                                "
                                    @change="triggerCheckboxModule($el)"
                                />
                                <span class="capitalize"><strong>{{ $submodule }}</strong></span>
                            </label>
                            @foreach ($permissions as $index => $permission)
                                <div class="grid grid-cols-3">
                                    <div class="flex items-center gap-4 ml-4">
                                        <label
                                            class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                            <input id="permission-{{ $submodule }}-{{ $index }}" type="checkbox"
                                                name="permission_id[]"
                                                aria-labelledby="{{ $submodule }}"
                                                value="{{ $permission->id }}"
                                                class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                                @foreach ($role->permissions as $rolePermission)
                                                    @if ($rolePermission->id == $permission->id) checked @endif 
                                                @endforeach
                                                @change="triggerCheckboxPermission($el)"
                                            />
                                            <span>{{ $permission->name }}</span>
                                        </label>
                                    </div>
                                    <div class="col-span-2">
                                        <x-text>{{ $permission->description }}</x-text>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <x-hr></x-hr>
                    @endforeach
                    <x-input-error :messages="$errors->get('permission_id')" />
                    <x-input-error :messages="$errors->get('permission_id.*')" />
                </div>
                <div class="flex items-center justify-between gap-2 mt-8">
                    <x-link href="{{ route('dashboard.config.role.index') }}" style="outline">{{ __('Back') }}</x-link>
                    <x-button type="submit">{{ __('Save') }}</x-button>
                </div>
            </form>
        </div>
    </x-card>
</x-layouts.dashboard>
