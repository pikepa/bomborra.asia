<div class="px-2">
  <!-- This Section allows adding and update forms -->

  <div class="block">
    @if($showAddForm )
    @include('livewire.posts.create')
    @endif

    @auth
    @if($post_id)
    <livewire:images.upload :post_id="$post->id" />
    @endif
    @endauth

  </div>
  @if($showTable)
  <div>
    <div>
      @if (session()->has('message') && $showAlert = true)
      <x-forms.success />
      @endif
    </div>
  </div>
  <x-pages.dash-page-sub-head title="Posts" btntext="Add Post">
    A list of all the posts in your account.
  </x-pages.dash-page-sub-head>

  <div class="-my-2 mt-2 flex flex-col">
    <div class="my-2 overflow-x-auto ">
      <div class="flex flex-row justify-left items-center py-2 ">
        <div class="">
          <x-input wire:model.live.debounce.250ms="search" class="p-2 border-2 border-gray-600 " placeholder="Search Title"></x-input>
        </div>
        <div class="ml-4">
          <x-button.link wire:click="$toggle('showFilters')">
            @if ($showFilters) Hide @endif Advanced Filters...</Search></x-button.link>
        </div>
      </div>
      <!-- Advanced Search -->
      <div>
        @if ($showFilters)
        <div class=" bg-cool-gray-200 p-4 rounded shadow-inner ">
            <div class="flex flex-row justify-start items-center  space-x-4">
              <div class="w-1/4">
                <x-input.group inline for="channel" label="Channel Filter">
                  <livewire:forms.channel-select wire:model.live="channelQuery"/>
                </x-input.group>
              </div>
              <div class="w-1/4">
                <x-input.group inline for="filter-category" label="Category Filter">
                  <livewire:forms.category-select wire:model.live="categoryQuery"/>
                </x-input.group>
              </div>
              <div class="mt-2 hidden">
                <x-input.group inline for="filter-status" label="Status Filter">
                  <div class="mb-2 ">
                    <select wire:model.live='statusQuery' class=" rounded-lg p-1 border-2 border-gray-600 "
                      placeholder="Select Status">
                      <option value="">Select Status</option>
                      @foreach($queryStatuses as $status_item)
                      <option value="{{ $status_item }}">{{ $status_item }}</option>
                      @endforeach
                    </select>
                  </div>
                </x-input.group>
              </div>
              <div class="mt-2 p-4">
                <button wire:click='clearFilter()' class="mt-4 p-2 rounded-lg bg-teal-200">Clear</button>
              </div>
            </div>
        </div>
        @endif
      </div>

      <!-- This is the table section of the page -->

      <div class=" overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg"></div>
      <div class="relative">
        <x-table>
          <x-slot name="head">
            <x-table.row>
              <x-table.heading class="text-left">Title</x-table.heading>
              <x-table.heading class="text-left">Channel</x-table.heading>
              <x-table.heading class="text-left">Category</x-table.heading>
              <x-table.heading class="text-left">Author</x-table.heading>
              <x-table.heading class="text-left">Status</x-table.heading>
              <x-table.heading class="text-left">Published</x-table.heading>
              <x-table.heading class="text-left"></x-table.heading>
              <x-table.heading class="text-left"></x-table.heading>
            </x-table.row>
          </x-slot>
          <x-slot name="body">
            @forElse($posts as $post)
            <x-table.row wire:key="{{ $post->id }}">
              <x-table.cell class=" text-sky-600 font-bold dark:text-sky-400"><a
                  href="/posts/{{$post->slug}}">{{$post->title}}</a></x-table.cell>
              <x-table.cell class="truncate ...">{!! Str::limit($post->channel->name, 15 , ' ...') !!}</x-table.cell>
              <x-table.cell>{{$post->category->name}}</x-table.cell>
              <x-table.cell class="truncate ...">{{$post->author->name}}</x-table.cell>
              <x-table.cell>{{$post->published_status}}</x-table.cell>
              @isset($post->published_at)<x-table.cell
                class="text-left">{{$post->published_at->toFormattedDateString()}}</x-table.cell>@endisset
              @empty($post->published_at)<x-table.cell class="text-left">Draft</x-table.cell>@endempty
              <x-table.cell class="text-sky-600 font-bold dark:text-sky-400"><a href="/posts/edit/{{$post->slug}}/D"><i
                    class="fa-solid fa-pen-to-square"></i></a>
              </x-table.cell>
              <x-table.cell>
                <x-button.link wire:click="delete({{ $post->id }})"><i class="fa-regular fa-trash-can"></i>
                </x-button.link>
              </x-table.cell>
            </x-table.row>
            @empty
            <x-table.row>
              <x-table.cell colspan="7">
                <div class="flex justify-center items-center text-red-600 font-semibold text-xl">
                  <span>No Posts found</span>
                </div>
              </x-table.cell>
            </x-table.row>
            @endforelse
          </x-slot>
        </x-table>
      </div>
      <!-- <div wire:loading class="absolute inset-0 bg-white opacity-50"> </div> -->
      <!-- <div wire:loading.flex class="flex justify-center items-center absolute inset-0">
        <x-icon.spinner size="10" />
      </div> -->
    </div> 
  </div>
  <div class="pt-4 flex justify-between items-center">
    <div class="text-gray-700 text-sm">
      Total Results : {{ $posts->total() }}
    </div>
    <div class="flex flex-row items-center justify-between">

      <div class="mr-4">
        <button wire:click="resetPage">Top</button>
      </div>
      <div>
        {{ $posts->links() }}
      </div>
    </div>
  </div>


  @endif
</div>