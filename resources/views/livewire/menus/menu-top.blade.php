<div>
    <!-- This is the top menu and on mobile includes all menu items -->
    <div class="rounded-lg p-2 font-extrabold text-white bg-teal-800 ">

        <div x-data="{ open: false }" class="sm:hidden">

            <div x-on:click="open = ! open" class=" m-2 ml-4 text-3xl">
                <span x-cloak x-show="!open"><i class="fa fa-bars" aria-hidden="true"></i></span>
                <span x-cloak x-show="open"><i class="far fa-times-circle  "></i></span>
            </div>
            <div class="flex flex-row">
                <div x-show="open" x-transition.duration.2s
                    class="w-56 max-w-sm rounded-lg overflow-hidden shadow  mr-4 pl-4 ">
                    <ul class="pl-4 list-disc">
                        <x-menus.item routename='home'>Home</x-menus.item>
                        @foreach($m_categories as $category)
                        <li><a href="{{ url('/category/posts/'. $category->slug ) }}" class="hover:font-bold">{{
                                $category->name }} </li></a>
                        @endforeach
                    </ul>
                </div>
                <div x-show="open" x-transition.duration.2s
                    class="w-56 max-w-sm rounded-lg overflow-hidden shadow  mr-4 pl-4 ">
                    <ul class="pl-4 list-disc">
                        <x-menus.item routename='welcome'>About</x-menus.item>
                        @foreach($s_categories as $category)
                        <li><a href="{{ url('/category/posts/'. $category->slug ) }}" class="hover:font-bold">{{
                                $category->name }} </li></a>
                        @endforeach
                    </ul>
                </div>
            </div>


        </div>
        <div class="">
            <div
                class="hidden uppercase sm:flex flex-col justify-left sm:flex-row sm:justify-between sm:items-center p-2 ">
                <a href="/home">
                    <div>Home</div>
                </a>
                @foreach($m_categories as $category)

                <a href="/category/posts/{{$category->slug}}">
                    <div>{{$category->name}}</div>
                </a>
                @endforeach
                <div class="collapse sm:visible">
                    <!-- <input class='text-gray-700 p-2 rounded' type="text" placeholder="Search"> -->
                </div>
            </div>
        </div>

    </div>
</div>