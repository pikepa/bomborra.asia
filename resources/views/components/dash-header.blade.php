<div class="mb-2 min-h-34 bg-slate-200 rounded-lg flex flex-row justify-between">
    <div class="-ml-1 flex flex-row text-xl font-semibold space-x-4 items-center ">
        <div class="cursor-pointer text-2xl font-semibold rounded-xl py-2 px-2 bg-cyan-200"><a href="{{ route('home') }}">Home</a></div>
        <div class="inline p-2 cursor-pointer" ><a href="{{ url('dashboard/dash') }}">Dashboard</a></div>
        <div class="inline p-2 cursor-pointer" ><a href="{{ url('dashboard/categories') }}">Categories</a></div>
        <div class="inline p-2 cursor-pointer" ><a href="{{ url('dashboard/channels') }}">Channels</a></div>
        <div class="inline p-2 cursor-pointer" ><a href="{{ url('dashboard/posts') }}">Posts</a></div>
        <div class="inline p-2 cursor-pointer" ><a href="{{ url('dashboard/links') }}">Links</a></div>
        <div class="inline p-2 cursor-pointer" ><a href="{{ url('dashboard/subs') }}">Subscribers</a></div>
     
        <div class="inline p-2 cursor-pointer" ><a href="{{ route('site-updates') }}">Compose</a></div>
    </div>

    @auth
    <div class="mr-2 flex flex-row text-lg font-semibold space-x-4 items-center">
        <div>
            Hi {{auth()->user()->name}}
        </div>
        <div class="text-end ">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                            this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
    @endauth
</div>