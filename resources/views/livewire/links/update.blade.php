<div>
    <x-forms.card title="Edit Link">
        <x-forms.errors :errors="$errors"></x-forms.errors>
        <form wire:submit="update({{ $this->link_id }})">
            @include('livewire.links.form' )
        </form>
    </x-forms.card>
</div>