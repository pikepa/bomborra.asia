<div>
  <div class="w-1/2 mx-auto">
    @if($showAddForm)
    @include('livewire.links.create')
    @endif

    @if($showEditForm)
    @include('livewire.links.update')
    @endif
  </div>

  @if($showTable)
  <div>
    @if (session()->has('message') && $showAlert = true)
    <x-forms.success />
    @endif
  </div>
  <div class="text-xl font-semibold text-gray-900">Subscribers.</div>
  <div class="mt-2 text-sm text-gray-700">A list of all the Subscribers in your account.</div>

  <!-- This is the table section of the page -->
  <div class="mt-2 flex flex-col">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
        <div class=" mb-2 ">
          <x-input wire:model="search" class="w-1/3 p-1 border-2 border-gray-600 " placeholder="Search Title"></x-input>
        </div>
        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">

          <x-table wire:loading.class="opacity-50">
            <x-slot name="head">

              <x-table.row>
                <x-table.heading class="text-left">Name</x-table.heading>
                <x-table.heading class="text-left">Email</x-table.heading>
                <x-table.heading class="text-left">Validated</x-table.heading>
                <x-table.heading class="text-left">Created</x-table.heading>
                <x-table.heading class="text-left"></x-table.heading>
              </x-table.row>
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
        </div>
      </div>
    </div>
  </div>
  @endif

</div>