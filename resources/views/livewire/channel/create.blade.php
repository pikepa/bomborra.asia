<div class="bg-cyan-50">
    <x-forms.card title="Add Channel">
        <x-forms.errors :errors="$errors"></x-forms.errors>
        <form wire:submit="save">
 
            @include('livewire.channel.form')
      
        </form>
    </x-forms.card>
</div>
