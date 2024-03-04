<x-guest-layout>
    <x-pages.standard-page>
        <div onclick="location.href='/';" class="cursor-pointer">
            <menus class="grid grid-cols-1 border-b-2  ">

                <livewire:menus.menu-top />

                <x-menus.menu-middle />

                <livewire:menus.menu-bottom />

            </menus>
        </div>

        <div class="mt-4">
            <div class="max-w-7xl mx-auto">
                <div class=" border-gray-900 border-2 rounded-lg">
                    <div class="flex flex-row justify-between items-center">
                        <div class="ml-4 text-3xl pt-4  text-gray-700 font-bold">
                            {{$post->title}}
                            @if($post->published_status == 'Published') <p class="text-xs font-bold text-gray-600">
                                Published on
                                {{$post->display_published_at }} by {{$post->author->name}}</p>
                            @else <p class="text-xs font-bold text-gray-600">{{ $post->published_status }}
                                by {{$post->author->name}}</p>
                            @endif
                        </div>
                        <div class="flex text-right mr-4 font-bold text-xl">
                            @if(Auth::user())
                            <div class="mr-4">
                                <a href="/posts/edit/{{ $post->slug }}/P"><i class="fa-solid fa-pen-to-square"></i></a>
                            </div>
                            @endif
                            <a href="{{ url()->previous() }}"><i class="fa-solid fa-arrow-left"></i> Back </a>
                        </div>

                    </div>
                    <div class=" overflow-hidden shadow-sm rounded-lg pb-4">
                        <div class="p-4">
                            <div style="float:left;" class="mr-6">
                                <img class="rounded-lg" src="{{$post->cover_image}}" width='400px' alt="Cover Image">
                            </div>

                            <div class="trix-content">
                                {!!$post->body!!}
                            </div>

                        </div>

                    </div>
                    <!-- This is the post gallery -->
                    <div class="p-4">
                        <livewire:posts.display-post-gallery :post="$post">
                    </div>
                </div>

                <div class="mt-2">
                </div>
            </div>
        </div>
    </x-pages.standard-page>
</x-guest-layout>