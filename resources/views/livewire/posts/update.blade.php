<div>
    
        <x-forms.card title="Edit Post">
            <x-forms.errors :errors="$errors"></x-forms.errors>
            <form wire:submit="update()">
                @include('livewire.posts.form', ['selectedCategory'=>$form->selectedCategory,
                'selectedChannel'=>$form->selectedChannel, ] )
            </form>

         </x-forms.card>
</div>      