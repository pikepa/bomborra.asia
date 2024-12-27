<div>
    <x-forms.card title="Edit Channel">
        <x-forms.errors :errors="$errors"></x-forms.errors>
        <form wire:submit="update({{ $this->channel_id }})">
            @include('livewire.channel.form' )
        </form>
    </x-forms.card>
</div>