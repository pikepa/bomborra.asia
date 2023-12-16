<x-pages.dash-standard-template>
  <div class="w-1/2 mx-auto">
    @if($showAddForm)
    @include('livewire.links.create')
    @endif

    @if($showEditForm)
    @include('livewire.links.update')
    @endif
  </div>

  @if($showTable)
  <div class = 'flex-col space-y-4'>
    <div class="flex justify-between items-center">
      <div>
        <x-pages.title.left>Footer Links</x-pages.title.left>
      </div>
      <div>
        @if (session()->has('message') )
        <x-forms.success />
        @endif
      </div>
    </div>
    <div class="flex justify-between items-center">
      <div class="ml-2 w-1/4">
        <x-input.text wire:model="search" class="rounded-md p-2 border-2 border-gray-300"
          placeholder="Search title .."></x-input.text>
      </div>

      <div class="mr-2 space-x-2 flex items-center">
        <div>
          @if($selected)
          <x-dropdown label="Bulk Actions">
            <x-dropdown.item type='button' wire:click='deleteSelected' class="flex items-center space-x-2">
              <x-icons.trash class="text-cool-gray-200" /><span>Delete</span>
            </x-dropdown.item>
          </x-dropdown>
          @endif
        </div>
        <x-button.primary wire:click="create"><x-icons.plus /> <span>Add New</span></x-button.primary>
      </div>
    </div>

    <!-- This is the table section of the page -->

    <x-table wire:loading.class="opacity-50">
      <x-slot name="head">
        <x-table.row>
          <x-table.heading sortable wire:click="sortBy('title')"
          :direction="$sortField === 'title' ? $sortDirection :null">Title</x-table.heading>
          <x-table.heading >Url</x-table.heading>
          <x-table.heading sortable wire:click="sortBy('position')"
          :direction="$sortField === 'position' ? $sortDirection :null">Position</x-table.heading>
          <x-table.heading >Sort</x-table.heading>
          <x-table.heading >Status</x-table.heading>
          <x-table.heading ></x-table.heading>
          <x-table.heading ></x-table.heading>
        </x-table.row>
      </x-slot>
      <x-slot name="body">
        @forEach($links as $link)
        <x-table.row>
          <x-table.cell>{{$link->title}}</x-table.cell>
          <x-table.cell>{{$link->url}}</x-table.cell>
          <x-table.cell>{{$link->position}}</x-table.cell>
          <x-table.cell>{{$link->sort}}</x-table.cell>
          <x-table.cell>{{$link->status}}</x-table.cell>
          <x-table.cell>
            <x-button.link wire:click="edit({{ $link->id }})"><i class="fa-solid fa-pen-to-square"></i>
            </x-button.link>
          </x-table.cell>
          <x-table.cell>
            <x-button.link wire:click="delete({{ $link->id }})"><i class="fa-regular fa-trash-can"></i>
            </x-button.link>
          </x-table.cell>
        </x-table.row>
        @endforeach
      </x-slot>
    </x-table>
    <div>
      {{ $links->links() }}
    </div>
    @endif
  </div>
</x-pages.dash-standard-template>