<x-modal name="confirm-approval">
    <div class="space-y-8">
        <div class="space-y-1">
            <x-subtitle>
                {{ __('Are you sure you want to update the status?') }}
            </x-subtitle>
            <x-text x-text="`{{ __('You are about to update the status of order for ${name}.') }}`"></x-text>
        </div>
        <div class="flex justify-end gap-2">
            <x-button style="secondary" @click="$dispatch('close')">{{ __('Cancel') }}</x-button>
            <form :action="`/dashboard/order/approve/${id}`" method="POST" id="update-status-form">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" :value="document.querySelector(`input[name=\'status-${id}\']:checked`) ? document.querySelector(`input[name=\'status-${id}\']:checked`).value : ''">
                <x-button type="submit" style="primary">{{ __('Confirm') }}</x-button>
            </form>
        </div>
    </div>
</x-modal>
