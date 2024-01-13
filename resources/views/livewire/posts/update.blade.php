<div>
    
        <x-forms.card title="Edit Post">
            <x-forms.errors :errors="$errors"></x-forms.errors>
            <form wire:submit.prevent="update({{ $this->post_id }})">
                @include('livewire.posts.form', ['selectedCategory'=>$selectedCategory,
                'selectedChannel'=>$selectedChannel, ] )
            </form>

    </x-forms.card>
</div>      