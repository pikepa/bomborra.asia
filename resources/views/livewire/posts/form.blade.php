<div >
    <div wire:ignore class="flex justify-between border-2 rounded-lg p-4">
        <div  class="flex-1 mr-4 space-y-6">
            <!-- Post Title -->
            <x-input.group for="title" label="Title" width="full">
                <x-input.text 
                    wire:model='form.title' 
                    type="text" 
                    class="form-input w-full rounded" >
                </x-input.text>
            </x-input.group>
            
            <!-- Post Body -->
            <x-input.group  wire:ignore for="body" label="Body" width="full">
                <x-input.rich-text 
                    wire:model='form.body' 
                    :initial-value='$form->body'
                    unique="body" 
                    type="text" />
                </x-input.group>

            <!-- Meta Description -->
            <x-input.group for="meta_description" label="Meta Description" width="full">
                <x-input.textarea 
                    wire:model='form.meta_description' 
                    type="text" 
                    class="form-input w-full rounded" >
                </x-input.textarea>
            </x-input.group>

        </div>
        <div class=" space-y-6">
            <!-- Post Channel -->
            <div>
                <x-input.group for="Channel_id" label="Channel" width="full">
                    <livewire:forms.channel-select wire:key="channel_select" wire:model="form.channel_id"/>
                </x-input.group>
            </div>

            <!-- Post Category -->
            <div>
                <x-input.group for="category" label="Category" width="full">
                    <livewire:forms.category-select wire:key="category_select" wire:model="form.category_id"/>
                </x-input.group>
            </div>

            <!-- Post is in the Vault -->
            <div>
                <x-input.group for="is_in_vault" label="Post is in our Vault" width="full">
                    <input wire:model='form.is_in_vault' type="checkbox" class="ml-2">
                </x-input.group>
            </div>

            <!-- Publish Post -->
            <div x-data>
                @isset($form->post->id)
                    <label class=" flex flex-row justify-between items-center">
                        <span class="text-gray-700  font-bold">Published : @if($form->published_at){{
                            $form->published_at->format('d-M-Y') }}@endif</span>
                        @if(! $form->published_at)
                        <x-button.secondary wire:click.prevent="publishPost()" class="bg-blue-400">
                            Publish Post
                        </x-button.secondary>
                        @endif
                        @if( $form->published_at)
                        <x-button.secondary wire:click.prevent="unpublishPost()" class="bg-blue-400">
                            Make Draft
                        </x-button.secondary>
                        @endif

                    </label>
                    @if(! $form->published_at)
                        <div>
                            <input wire:model='form.temp_published_at' type="text" placeholder="DD-MM-YYYY" name="published_at"
                                format="DD-MM-YYYY" class="form-input rounded mt-1 block w-full">
                        </div>
                    @endif
                @endisset
            </div>

            <!-- Checkbox for Featured Image-->
            @isset($form->cover_image)
            <div>
                <x-input.group label="Featured Image" for="cover_image"></x-input.group>

                <img class='rounded shadow-lg' src="{!!$form->cover_image!!}" width="250px" alt="Featured image">
            </div>
            @endisset



            <!-- this is the save button -->
            @empty($form->newImage)
            <div class="flex justify-around">
                <div>
                    <button method="Submit" class="w-28 p-2 rounded-lg bg-green-500">
                        Save Post
                    </button>
                </div>

                <div>
                    <button wire:click='cancel' class="w-28 p-2 rounded-lg bg-orange-500">
                        Cancel
                    </button>
                </div>
            </div>
            @endempty

        </div>

    </div>

    <!-- This is the spot for the Post Gallery -->

</div>