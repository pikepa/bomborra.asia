<div>
    <x-forms.card title="Edit Category">
        <x-forms.errors :errors="$errors"></x-forms.errors>
        <form wire:submit="update({{ $this->category_id }})">
            @include('livewire.category.form' )
        </form>
    </x-forms.card>
</div>