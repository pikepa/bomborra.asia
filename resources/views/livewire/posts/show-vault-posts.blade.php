<div>
    <x-guest-layout>
        <x-pages.standard-page>
                <menus class="grid grid-cols-1 border-b-2 ">

                    <livewire:menus.menu-top />

                    <x-menus.menu-middle />

                    <livewire:menus.menu-bottom />

                </menus>
            <div class="">
                <div class="max-w-7xl bg-cyan-100 mx-auto ">
                    <div class=" flex flex-row justify-between items-center">
                        <div class="pt-2">
                            <div class="ml-4  font-bold text-3xl">
                                The Vault
                            </div>

                        </div>
                        <div class="text-right  mr-4 font-bold text-xl">
                            <a href="{{ url()->previous() }}"><i class="fa-solid fa-arrow-left"></i> Back</a>
                        </div>
                    </div>
                    <div class="ml-4 text-base">
                        The Vault is a collection of memorable stories, photographs and videos, which continue to resonate long after publication, including obituaries.
                    </div>

                    <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-2 bg-cyan-100 border-b border-gray-200">
                            @foreach($posts as $post)
                            <div class="flex flex-row border-2 border-gray-300 shadow-md rounded-md mb-2 p-2">
                                <div class="w-1/5">
                                    <img class="object-cover h-44 w-full rounded-md " src='{{$post->cover_image}}'
                                        alt="placeimg">
                                </div>
                                <div class="w-4/5 ml-4 max-h-36 overflow-hidden">
                                    <a href="../../posts/{{$post->slug}}";
                                        class="block text-lg leading-tight font-bold text-gray-900 hover:underline">{{$post->title}}</a>
                                    <p class="mt-2 text-gray-600">{!!$post->body!!}.</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </x-pages.standard-page>
    </x-guest-layout>

</div>