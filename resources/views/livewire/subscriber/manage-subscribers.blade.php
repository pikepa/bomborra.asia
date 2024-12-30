<x-pages.dash-standard-template>
  <div class="flex-col space-y-4">
    <div class="flex justify-between items-center">
      <div>
        <x-pages.title.left>Subscriber listing</x-pages.title.left>
      </div>
      <div>
        @if (session()->has('message'))
        <x-forms.success />
        @endif
      </div>
    </div>

    <!-- This is the table section of the page -->

    <div class="flex justify-between items-center">
      <div class="flex justify-left space-x-4 items-center">
        <div class="ml-2 ">
          <x-input wire:model.live="filters.search" class=" p-2 border-2 border-gray-300 "
            placeholder="Search subscriber name"></x-input>
        </div>
        <div>
          <x-button.link wire:click="$toggle('showFilters')">@if ($showFilters) Hide @endif Advanced
            Search..</x-button.link>
        </div>
      </div>

      <div class="mr-2 space-x-2 flex items-center">
        <x-dropdown label="Bulk Actions">
          <x-dropdown.item type='button' wire:click='validateSelected()' class="flex items-center space-x-2">
            <x-icons.inbox class="text-cool-gray-200" /><span>Validate Subscribers</span>
          </x-dropdown.item>
          <x-dropdown.item type='button' wire:click='deleteSelected' class="flex items-center space-x-2">
            <x-icons.trash class="text-cool-gray-200" /><span>Delete</span>
          </x-dropdown.item>
        </x-dropdown>
      </div>
    </div>
    <!-- Advanced Search -->
    <div>
      @if ($showFilters)
      <div class="bg-cool-gray-800 p-4 rounded shadow-inner ">
        <div class="flex relative items-start">
          <div class="w-1/3 pr-2 space-y-4">
            <x-input.group inline for="filter-status" label="Status">
              <x-input.select class='rounded' wire:model.live="filters.status" id="filter-status">
                <option value="" >Select Status...</option>
                 <option value='VAL'>VALIDATED</option>
                 <option value=NULL>UNVALIDATED</option>
              </x-input.select>
            </x-input.group>
          </div>

          <div class="w-1/3 pl-2 space-y-4 hidden ">
            <x-input.group inline  for="filter-val-date-min" label="Minimum Validation Date">
              <x-input.date class="py-2" wire:model.live="filters.val-date-min" id="filter-val-date-min" placeholder="MM/DD/YYYY" />
            </x-input.group>

            <x-input.group inline hidden for="filter-val-date-max" label="Maximum Validation Date">
              <x-input.date class="py-2" wire:model.live="filters.val-date-max" id="filter-val-date-max" placeholder="MM/DD/YYYY" />
            </x-input.group>
          </div>

          <div class="w-1/3 pl-2 space-y-4 hidden ">
            <x-input.group inline for="filter-create-date-min" label="Minimum Date Created">
              <x-input.date class="py-2" wire:model.live="filters.create-date-min" id="filter-create-date-min" placeholder="MM/DD/YYYY" />
            </x-input.group>

            <x-input.group inline for="filter-create-date-max" label="Maximum Date Created">
              <x-input.date class="py-2" wire:model.live="filters.crdate-max" id="filter-create-date-max" placeholder="MM/DD/YYYY" />
            </x-input.group>
          </div>
          <div>
            <x-button.link wire:click="resetFilters" class="absolute right-0 top-0 w-32 p-4">Reset Filters</x-button.link>
          </div>
        </div>

      </div>

      @endif
    </div>

    <x-table wire:loading class="opacity-50">
      <x-slot name="head">
        <x-table.heading class="pr-0 w-8">
          <x-input.checkbox wire:model.live="selectPage" />
        </x-table.heading>
        <x-table.heading sortable wire:click="sortBy('name')"
          :direction="$sortField === 'name' ? $sortDirection :null">Name</x-table.heading>
        <x-table.heading sortable wire:click="sortBy('email')"
          :direction="$sortField === 'email' ? $sortDirection :null">Email</x-table.heading>
        <x-table.heading sortable wire:click="sortBy('validated_at')"
          :direction="$sortField === 'validated_at' ? $sortDirection :null">Validated</x-table.heading>
        <x-table.heading sortable wire:click="sortBy('created_at')"
          :direction="$sortField === 'created_at' ? $sortDirection :null">Created</x-table.heading>
      </x-slot>

      <x-slot name="body">
      <div>
        @if($selectPage)
        <x-table.row class="bg-gray-100" wire:key="row-message">
          <x-table.cell class="text-lg" colspan="5">
            @unless($selectAll)
            <div>
            <span>You have selected <strong>{{ $subscribers->count() }}</strong> subscribers, do you want to select all <strong>{{ $subscribers->total() }}</strong>?</span>
            <x-button.link wire:click.='selectAll'
            class="ml-1  text-blue-600">Select All</x-button.link>
            </div>
            @else
            <span>You are currently selecting all <strong>{{ $subscribers->total() }}</strong> subscribers.</span>
            @endif
          </x-table.cell>
        </x-table.row>
        @endif
      </div>
        @forElse($subscribers as $subscriber)
        <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $subscriber->id }}">
          <x-table.cell class="pr-0">
            <x-input.checkbox wire:model.live='selected' value="{{ $subscriber->id }}"></x-input.checkbox>
          </x-table.cell>
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