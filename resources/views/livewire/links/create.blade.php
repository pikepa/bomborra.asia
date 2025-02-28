<div>
    <x-forms.card title="Add Link">
        <x-forms.errors :errors="$errors"></x-forms.errors>
        <form wire:submit="save">
 
            @include('livewire.links.form')
      
        </form>
    </x-forms.card>
</div>
