<x-pages.dash-standard-template>
  <div class="flex-col space-y-4">
    <div class="flex justify-between items-center">
      <div>
          <x-pages.title.left>Subscriber listing</x-pages.title.left>
      </div>
      <div >
          @if (session()->has('message') && $showAlert = true)
          <x-forms.success />
          @endif
      </div>
  </div>

      <!-- This is the table section of the page -->

      <div class="flex justify-between items-center">
          <div  class="flex justify-left space-x-4 items-center">
            <div class="ml-2 ">
              <x-input wire:model="search" class=" p-2 border-2 border-gray-300 " placeholder="Search subscriber name"></x-input>
            </div>
            <div >
              <label for="validated">Select Unvalidated: </label>
              <input class="ml-4" wire:model='isNotValidated' type="checkbox" name="validated" value=false>
            </div>
          </div>
        
          <div class="mr-2 space-x-2 flex items-center">
              <x-dropdown label="Bulk Actions">
                  <!-- <x-dropdown.item type='button' wire:click='' class="flex items-center space-x-2">
                      <x-icons.download class="text-cool-gray-200"/><span>Download</span>
                  </x-dropdown.item> -->
                  <x-dropdown.item type='button' wire:click='deleteSelected' class="flex items-center space-x-2">
                      <x-icons.trash class="text-cool-gray-200" /><span>Delete</span>
                  </x-dropdown.item>
              </x-dropdown>
              <!-- <x-button.primary wire:click="create"><x-icons.plus /> <span>Add New</span></x-button.primary> -->
          </div>
      </div>

      <x-table wire:loading.class="opacity-50">
        <x-slot name="head">
            <x-table.heading sortable class="text-left">Name</x-table.heading>
            <x-table.heading class="text-left">Email</x-table.heading>
            <x-table.heading class="text-left">Validated</x-table.heading>
            <x-table.heading class="text-left">Created</x-table.heading>
            <x-table.heading class="text-left"></x-table.heading>
        </x-slot>

        <x-slot name="body">
          @forElse($subscribers as $subscriber)
          <x-table.row>
            <x-table.cell class="font-bold"> {{$subscriber->name}}</x-table.cell>
            <x-table.cell>{{$subscriber->email}}</x-table.cell>
            @isset($subscriber->validated_at)
            <x-table.cell class="text-left">
              {{$subscriber->validated_at->toFormattedDateString()}}
            </x-table.cell>
            @endisset
            @empty($subscriber->validated_at)
            <x-table.cell class="text-left">
              Not Validated
            </x-table.cell>
            @endempty
            <x-table.cell>{{$subscriber->created_at->toFormattedDateString()}}</x-table.cell>

            <x-table.cell>
              <x-button.link wire:click="delete({{ $subscriber->id }})"><i class="fa-regular fa-trash-can"></i>
              </x-button.link>
            </x-table.cell>
          </x-table.row>

          @empty
          <x-table.row>
            <x-table.cell colspan="7">
              <div class="flex justify-center items-center text-red-600 font-semibold text-xl">
                <span>No Subscribers found</span>
              </div>
            </x-table.cell>
          </x-table.row>
          @endforelse
        </x-slot>
      </x-table>
      <div>
        {{ $subscribers->links() }}
    </div>
    </div>
  </div>
</x-pages.dash-standard-template>