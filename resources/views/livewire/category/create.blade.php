<div>
    <x-forms.card title="Add Category">
        <x-forms.errors :errors="$errors"></x-forms.errors>
        <form wire:submit="save">
 
            @include('livewire.category.form')
      
        </form>
    </x-forms.card>
</div>
