<x-card class="mt-8">
    <div class="max-w-xl">
        <div class="space-y-8">
            <div class="space-y-1">
                <x-subtitle>
                    {{ __('Customer Information') }}
                </x-subtitle>
                <x-text> {{ __("Update your account's customer informatio.") }} </x-text>
            </div>
            <form method="post" action="{{ route('profile.update.customer') }}">
                @csrf
                @method('patch')

                <div class="space-y-4">
                    <div class="space-y-2">
                        <x-label for="phone_no">{{ __('Phone No') }}</x-label>
                        <x-input type="text" id="phone_no" name="phone_no"
                            value="{{ old('name', auth()->user()->customer->phone_no) }}" placeholder="Enter phone no" required
                            autofocus></x-input>
                        <x-input-error :messages="$errors->get('phone_no')" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="address">{{ __('Address') }}</x-label>
                        <x-input type="text" id="address" name="address"
                            value="{{ old('name', auth()->user()->customer->address) }}" placeholder="Enter address" required
                            autofocus></x-input>
                        <x-input-error :messages="$errors->get('address')" />
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-8">
                    <x-button type="submit">{{ __('Save') }}</x-button>

                    @if (session('status') === 'customer-updated')
                        <x-text x-data="{ show: true }" x-show="show" x-transition
                            x-init="setTimeout(() => show = false, 2000)">{{ __('Saved.') }}</x-text>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-card>
