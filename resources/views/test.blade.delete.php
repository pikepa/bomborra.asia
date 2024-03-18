<x-app-layout>
    <x-pages.standard-page>
        <x-forms.card title="Add Post">

            <!-- Post Title -->

            <x-input.group for="title" label="Title" width="full">
                <x-input.text wire:model.live='title' type="text" class="form-input w-full rounded" name="name">
                </x-input.text>
            </x-input.group>

            <!-- Post Category -->

            <x-input.group for="body" label="Body" width="full">
                <x-input.textarea wire:model='body' rows=10 type="text" />
            </x-input.group>

            <!-- Post Category -->
            <div>
                <x-input.group for="category" label="Body" width="full">
                    <livewire:forms.category-select wire:model='category_id' :cat_id="$selectedCategory" />
                </x-input.group>
            </div>

        </x-forms.card>
    </x-pages.standard-page>
</x-app-layout>