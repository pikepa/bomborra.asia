<div>
    <div class='mt-4 '>
        <div class="border-2 rounded-lg bg-slate-50">
            <div class="text-xl font-bold pt-2 p-1  mt-2">
                <div class="ml-2 mb-2">
                    Post Gallery
                </div>
                <main class="py-4 border-2 rounded-lg">

                    <ul role="list"
                        class="ml-2 grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                        @forelse($post->getMedia('photos') as $image)
                        <li class="relative">
                            <div
                                class=" group aspect-w-10 aspect-h-7 block w-full overflow-hidden rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100">
                                <img class="object-cover" src="{{ $image->getUrl() }} " alt="Thumbnail is Missing here">
                            </div>
                            @auth
                            <div class="px-4 pt-2 flex justify-between">
                                <button wire:click='deleteImage({{ $image->id }}, "{{ $post->id  }}")'>
                                    <i class="fas fa-trash"></i>
                                </button>
                                <div>
                                    <livewire:images.pin-images :image="$image"/>
                                </div>

                                <button wire:click='changeFeatured("{{ $image->getUrl() }}", "{{ $post->id }}" )'>
                                    <i class="fas fa-bolt"></i>
                                </button>
                            </div>

                            @endauth
                        </li>

                        <!-- More files... -->
                        @empty
                        <div class="pt-2 ">
                            There are no related image files
                        </div>
                        @endforelse
                    </ul>
                </main>
            </div>
        </div>


        <div class="mb-4 mt-2">
            <form wire:submit="save">
                <div class="font-semibold text-xl pb-4">
                    <label for="load_image">Choose an image to Upload:</label><br>
                </div>
                <div class="flex justify-left items-center">
                    <div>
                        <input type="file" name="load_image" wire:model.live='photo'>
                        @error('photo') <span class="error">{{ $message }}</span> @enderror
                    </div>


                    @empty(!$photo)
                    <div>
                        <button type="submit" class="py-2 px-4 rounded-lg bg-indigo-400 btn">Upload</button>
                    </div>
                    @endempty
                </div>
            </form>
        </div>
    </div>
</div>