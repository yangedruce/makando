@php
    $title = 'Update Password';
@endphp

<x-layouts.auth>
    <x-slot:title>
        {{ $title }}
    </x-slot>
    <x-title>{{ $title }}
    </x-title>
    <form id="password-form" method="POST" action="{{ route('password.change.update') }}"class="mt-8">
        @csrf

        @method('put')
        <div class="space-y-4">
            <div class="space-y-2">
                <x-label for="current-password">{{ __('Current password') }}</x-label>
                <x-input type="password" id="current-password" name="current_password"
                    placeholder="Enter current password" required autofocus
                    autocomplete="current-password"></x-input>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" />
            </div>
            <div class="space-y-2">
                <x-label for="new-password">{{ __('New password') }}</x-label>
                <x-input type="password" id="new-password" name="password" placeholder="Enter new password"
                    required autofocus autocomplete="new-password"></x-input>
                <x-input-error :messages="$errors->updatePassword->get('password')" />
            </div>
            <div class="space-y-2">
                <x-label for="confirm-password">{{ __('Confirm new password') }}</x-label>
                <x-input type="password" id="confirm-password" name="password_confirmation"
                    placeholder="Enter current password" required autofocus
                    autocomplete="current-password"></x-input>
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
            </div>
        </div>
    </form>

    <div class="flex items-center justify-end gap-4 mt-8">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-button type="submit" style="link">
                {{ __('Log Out') }}
            </x-button>
        </form>
        <x-button x-data="{}" @click="
        console.log('test');
            const form = document.getElementById('password-form');
            form.checkValidity() ? form.submit() : form.reportValidity();
            "
            type="button" class="text-white bg-red-800 w-80 hover:bg-red-700">
            {{ __('Update password') }}
        </x-button>
    </div>
</x-layouts.auth>
