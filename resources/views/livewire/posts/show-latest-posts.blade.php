<div>
    <x-guest-layout>
        <x-pages.standard-page>
            <div onclick="location.href='/';" class="cursor-pointer">
                <menus class="grid grid-cols-1 border-b-2 ">

                    <livewire:menus.menu-top />

                    <x-menus.menu-middle />

                    <livewire:menus.menu-bottom />

                </menus>
            </div>
            <div class="">
                <div class="max-w-7xl bg-cyan-100 mx-auto ">
                    <div class=" flex flex-row justify-between items-center">
                        <div class="pt-2">
                            <div class="ml-4  font-bold text-3xl">
                                Recent Posts
                            </div>

                        </div>
                        <div class="text-right  mr-4 font-bold text-xl">
                            <a href="{{ url()->previous() }}"><i class="fa-solid fa-arrow-left"></i> Back</a>
                        </div>
                    </div>
<div class="flex items-center justify-between">
    <div class="ml-4 text-base flex items-center space-x-4 ">
        <div>Our offerings for the last </div>
        <div class="flex justify-start items-center space-x-2">
            <x-input.select wire:model='period' class="rounded-2xl border-0">
                <option wire:key="months.{{ 3 }}" value="3">3</option>
                <option wire:key="months.{{ 6 }}" value="6">6</option>
                <option wire:key="months.{{ 9 }}" value="9">9</option>
            </x-input.select>
            <div>months</div>
        </div>
    </div>
    <div class="mr-2 pb-2 pt-4">
        {!! $posts->links('pagination::tailwind_custom')!!}
    </div>
</div>
                    <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-2 bg-cyan-100 border-b border-gray-200">
                            @if($posts->count() > 0 )
                            @foreach($posts as $post)

                            <x-listings.image-text-combo :post="$post" />

                            @endforeach
                            @else
                            <div class="p-2">Sorry, there are no Articles within this time period</div>
                            @endif()
                        </div>
                    </div>
                </div>
            </div>
        </x-pages.standard-page>
    </x-guest-layout>

</div>