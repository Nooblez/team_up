<x-app-layout>
    <form method="POST" action="{{ route('labels.create') }}" name="form">
        @csrf
        <div class="col-span-6">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label name="name" for="name" value="Label Name" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autofocus name="name"/>
                <x-jet-input-error for="name" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="description" value="Label Description" />
                <x-textarea name="description" title="description" id="description" class="mt-1 block w-full" wire:model.defer="state.description" autofocus></x-textarea>
                <x-jet-input-error for="description" class="mt-2" />
            </div>
        </div>
        <x-jet-button type="submit">
            {{ __('Create') }}
        </x-jet-button>
    </form>
</x-app-layout>