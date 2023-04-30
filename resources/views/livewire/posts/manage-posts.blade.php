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

  <!-- This is the table section of the page -->
  <div class="mt-2 flex flex-col">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="flex flex-row justify-left items-center py-2 md:px-6 lg:px-8">
        <div class=" mb-2 ">
          <x-input wire:model="search" class=" p-1 border-2 border-gray-600 " placeholder="Search Title"></x-input>
        </div>
        <div class=" mb-2 ml-4 ">
<p>Channel Filter:</p>
        </div>
        <div class=" mb-2 ">
          <select wire:model="channelQuery" class=" ml-2 rounded-lg p-1 border-2 border-gray-600 "
            placeholder="Select Channel">
                <option value="">Select Channel</option>
            @foreach($queryChannels as $channel_item)
                <option value="{{ $channel_item->id }}">{{ $channel_item->name }}</option>
            @endforeach
          </select>
        </div>
        <div class=" mb-2 ml-4">
          <p>Category Filter:</p>
                  </div>
        <div class=" mb-2 ">
          <select wire:model='categoryQuery' class=" ml-2 rounded-lg p-1 border-2 border-gray-600 "
            placeholder="Select Category">
                <option value="">Select Category</option>
            @foreach($queryCategories as $category_item)
                <option value="{{ $category_item->id }}">{{ $category_item->name }}</option>
            @endforeach
          </select>
        </div>
        <div class=" mb-2 ml-4">
          <button wire:click='clearFilter()' class="p-1 rounded-lg bg-teal-400">Clear</button>
        </div>
      </div>
      <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">

        <x-table wire:loading.class="opacity-50">
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
            <x-table.row>
              <x-table.cell class="text-sky-600 font-bold dark:text-sky-400"><a
                  href="/posts/{{$post->slug}}">{{$post->title}}</a></x-table.cell>
              <x-table.cell>{{$post->channel->name}}</x-table.cell>
              <x-table.cell>{{$post->category->name}}</x-table.cell>
              <x-table.cell>{{$post->author->name}}</x-table.cell>
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
    </div>
  </div>
</div>
@endif
</div>