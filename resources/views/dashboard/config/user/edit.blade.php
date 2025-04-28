@php
    $title = 'User';
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
                    {{ __('User Information') }}
                </x-subtitle>
            </div>
            <form method="post" action="{{ route('dashboard.config.user.update', $user->id) }}"
                x-data="{
                    isUpdatePasswordChecked: false,
                    isInputRoleIdError: false,
                    validateInputRoleId() {
                        let roleCheckboxes = document.querySelectorAll(`[name='role_id[]']:checked`);
                        (roleCheckboxes.length > 0) ? this.isInputRoleIdError = false: this.isInputRoleIdError = true;
                    },
                    validateForm() {
                        $el.reportValidity();
                        this.validateInputRoleId();
                        if (!this.isInputRoleIdError &&
                            $el.checkValidity()) {
                            $el.submit();
                        }
                    },
                }"
            >
                @csrf
                @method('patch')

                <div class="max-w-xl space-y-4">
                    <div class="space-y-2">
                        <x-label for="name">{{ __('Name') }}</x-label>
                        <x-input id="name" name="name" value="{{ $user->name }}" placeholder="{{ __('Enter name') }}"
                            required autofocus />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="email">{{ __('Email') }}</x-label>
                        <x-input type="email" id="email" name="email" value="{{ $user->email }}"
                            placeholder="{{ __('Enter email') }}" required />
                        <x-input-error :messages="$errors->get('email')" />
                    </div>
                    <div class="space-y-2">
                        <label
                            class="flex items-center gap-2 text-sm text-neutral-800 dark:text-neutral-200">
                            <input id="is-update-password" type="checkbox"
                                name="is_update_password"
                                aria-labelledby="{{ __('Update password') }}"
                                class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                @change="$el.checked ? isUpdatePasswordChecked = true : isUpdatePasswordChecked = false"
                            />
                            <span>{{ __('Update password') }}</span>
                        </label>
                    </div>
                    <div class="space-y-2">
                        <x-label for="password">{{ __('Password') }}</x-label>

                        {{-- 
                            readonly attribute is added to disable browser's auto save password popup.
                            refer: https://stackoverflow.com/a/32775859
                        --}}
                        <x-input type="password" id="password" name="password" placeholder="{{ __('Enter password') }}" ::value="if(!isUpdatePasswordChecked) ''" ::required="isUpdatePasswordChecked" ::disabled="!isUpdatePasswordChecked" ::readonly="!isUpdatePasswordChecked"/>
                        <x-input-error :messages="$errors->get('password')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="password-confirmation">{{ __('Confirm Password') }}</x-label>

                        {{-- 
                            readonly attribute is added to disable browser's auto save password popup.
                            refer: https://stackoverflow.com/a/32775859
                        --}}
                        <x-input type="password" id="password-confirmation" name="password_confirmation"
                            placeholder="{{ __('Confirm password') }}" ::value="if(!isUpdatePasswordChecked) ''" ::required="isUpdatePasswordChecked" ::disabled="!isUpdatePasswordChecked" ::readonly="!isUpdatePasswordChecked"/>
                        <x-input-error :messages="$errors->get('password_confirmation')" />
                    </div>
                    <div class="space-y-2">
                        <label
                            class="flex items-center gap-2 text-sm text-neutral-800 dark:text-neutral-200" :class="{'opacity-60' : !isUpdatePasswordChecked}">
                            <input id="is-force-password-change" type="checkbox" name="is_force_password_change" class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none" :disabled="!isUpdatePasswordChecked" :checked="if(!isUpdatePasswordChecked) false"/>
                            <span>{{ __('Force password change') }}</span>
                        </label>
                    </div>
                    <x-text><strong>Role:</strong></x-text>
                    @foreach ($roles as $index => $role)
                        
                        <div class="grid grid-cols-3">
                            <div class="flex items-center gap-4">
                                <label
                                    class="flex items-center gap-2 text-sm capitalize text-neutral-800 dark:text-neutral-200">
                                    <input id="role-id-{{ $index }}" type="checkbox"
                                        name="role_id[]"
                                        aria-labelledby="{{ $role->name }}"
                                        value="{{ $role->id }}"
                                        class="accent-neutral-800 dark:accent-neutral-200 disabled:pointer-events-none"
                                            @foreach ($user->roles as $userRole)
                                            @if ($role->id == $userRole->id) checked @endif 
                                        @endforeach
                                        @change="validateInputRoleId()"
                                    />
                                    <span>{{ $role->name }}</span>
                                </label>
                            </div>
                            <div class="col-span-2">
                                <x-text>{{ $role->description }}</x-text>
                            </div>
                        </div>
                    @endforeach

                    <x-text-danger class="invisible hidden"
                    ::class="{ 'hidden invisible': !isInputRoleIdError }">{{ __('Select at least 1 role.') }}</x-text-danger>
                    <x-input-error :messages="$errors->get('role_id')" />
                    <x-input-error :messages="$errors->get('role_id.*')" />
                </div>
                <div class="flex items-center justify-between gap-2 mt-8">
                    <x-link href="{{ route('dashboard.config.user.index') }}" style="outline">{{ __('Back') }}</x-link>
                    <x-button @click="validateForm()">{{ __('Save') }}</x-button>
                </div>
            </form>
        </div>
    </x-card>

</x-layouts.dashboard>
