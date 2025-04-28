<x-modal name="confirm-delete">
    <div class="space-y-8">
        <div class="space-y-1">
            <x-subtitle>
                {{ __('Are you sure you want to delete this?') }}
            </x-subtitle>
            <x-text
                x-text="`{{ __('Once user ${name} is deleted, all of its resources and data will be permanently deleted.') }}`"></x-text>
        </div>
        <div class="flex justify-end gap-2">
            <x-button style="secondary" @click="$dispatch('close')">{{ __('Cancel') }}</x-button>
            <x-button @click="
                        document.getElementById(`delete-form-${id}`).submit()"
                style="danger">{{ __('Delete') }}</x-button>
        </div>
    </div>
</x-modal>
