<div class="px-2">
    <x-dash-header />
    <div class="">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-cyan-50 border-b border-gray-200">
 
                    @if($show =='subs')
                    <livewire:subscriber.manage-subscribers />
                    @endif

                    @if($show =='compose')
                        <div >
                            <livewire:emails.show-update-emails  />
                        </div>                    
                    @endif

                    @if($show =='posts')
                    <livewire:posts.manage-posts />
                    @endif

                    @if($show =='channels')
                    <livewire:channel.manage-channels />
                    @endif

                    @if($show =='categories')
                    <livewire:category.manage-categories />
                    @endif

                    @if($show =='links')
                    <livewire:links.manage-links />
                    @endif

                    @if($show =='dash')
                    <x-pages.dashboard />
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>