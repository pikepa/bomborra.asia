<div>
    <!-- This is the bottom menu and on small screens just shows as a line, the items are included in the top menu -->
    <div class=" rounded-lg p-1 font-extrabold text-white bg-teal-800 ">
        <div >
            <div class="hidden uppercase sm:flex flex-col justify-left sm:flex-row sm:justify-between sm:items-center p-2 ">
                <a href="/">
                    <div>About Us</div>
                </a>
                @foreach($categories as $category)
                <a wire:key="{{ $category->id }}" href="/category/posts/{{$category->slug}}">
                    <div>{{$category->name}}</div>
                </a>
                @endforeach
                <div class="">
                    <a class="uppercase text-gray-100 pr-4 " href="/subscribers/create">Subscribe</a>

                    @auth
                    <a class="uppercase text-gray-100 pr-4 " href="{!! route('dashboard')!!}">Dashboard</a>
                    @endauth
                    @guest
                    <a class="uppercase text-gray-100 pr-4 " href="/login">Login</a>
                    @endguest
                </div>
            </div>
        </div>

    </div>
</div>