<x-form-section submit="createBoard">
    <x-slot name="title">
        {{ __('Create Your Board') }}
    </x-slot>

    <x-slot name="description">
        {{ __('A place to let your ideas grow.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name" autofocus />
            <x-input-error for="name" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="created">
            Created
        </x-action-message>

        <x-button>
            {{ __('Create') }}
        </x-button>
    </x-slot>
</x-form-section>