<div class="bg-cyan-100 p-2">
    <!-- source https://www.epicweb.dev/tutorials/fluid-hover-cards-with-tailwind-css/implementation/concluding-the-fluid-hover-cards-tutorial -->
    <div class="grid place-items-center ">
        <ul class="flex gap-4 w-full ">
            @foreach($posts as $post)
            <li
                class="flex-1 hover:grow-[1.3] transition-all bg-rose-300 h-[400px] w-full rounded-2xl relative overflow-hidden group">
                <a href="/posts/{{$post->slug}}">
                    <img class="absolute h-full w-full inset-0 object-cover" src='{{$post->cover_image}}'
                        alt="placeimg">
                    <div class="absolute inset-x-0 bottom-0 p-4 bg-gradient-to-t from-black from-30% ">
                        <div class="w-64">
                            <h2 class="text-2xl text-white font-medium leading-tight">{{$post->title}}</h2>
                            <div class="grid grid-rows-[0fr] group-hover:grid-rows-[1fr] transition-all">
                                <p class="mt-2 overflow-hidden text-white/70 line-clamp-3
                                 opacity-0 group-hover:opacity-100 duration-300 transition ">
                                    {{ strip_tags($post->body) }}
                                </p>
                            </div>
                        </div>

                    </div>
                </a>
            </li>
            @if($loop->iteration == 4)
            @break
            @endif
            @endforeach
        </ul>
    </div>
    <!-- <div class="grid sm:grid-cols-2 md:grid-cols-4 bg-cyan-100 gap-2"> -->
    <!-- @foreach($posts as $post )

            <x-posts.card :post="$post" />

            @if($loop->iteration == 4)
                @break
            @endif
        @endforeach -->
    <div>
        @if($this->postCount >= 5 )
        <div class="flex justify-end font-semibold text-2xl text-red-600 pt-2 px-2">
            <a href="{{ route('channelposts', ['chan_slug' => $this->channel->slug]) }}">Show More....</a>
        </div>
        @endif
    </div>

</div>