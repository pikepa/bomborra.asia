<x-pages.dash-standard-template>
    <div class="flex-col space-y-4">
        <div>
            <div>
                @if (session()->has('message') && $showAlert = true)
                <x-forms.success />
                @endif
            </div>
        </div>
    
        <div class="flex justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Site Updates</h1>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <button wire:click="create" type="button"
                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                    <i class="fa-solid fa-plus"></i>&nbspAdd New </button>
            </div>
        </div>
      
    
     <div class="flex-col space-y-4">
      <x-table>
        <x-slot name="head">
          <x-table.heading class="w-full">Subject</x-table.heading>
          <x-table.heading sortable>From</x-table.heading>
          <x-table.heading sortable>Status</x-table.heading>
          <x-table.heading sortable>Date</x-table.heading>
          <x-table.heading ></x-table.heading>
        </x-slot>
        <x-slot name="body">
          @foreach($siteUpdates as $siteupdate)
          <x-table.row wire:key="siteupdate-{{ $siteupdate->id }}">
            <x-table.cell>{{ $siteupdate->subject }}</x-table.cell>
            <x-table.cell>{{ $siteupdate->from }}</x-table.cell>
            <x-table.cell>{{ $siteupdate->status }}</x-table.cell>
            <x-table.cell  class="whitespace-nowrap">{{ $siteupdate->date_for_humans}}</x-table.cell>
            <x-table.cell>Edit</x-table.cell>
          </x-table.row>
          @endforeach
        </x-slot>
      </x-table>
      <div>
        {{ $siteUpdates->links() }}
      </div>
     </div>
    <!-- This is the modal form  -->
    
        <x-modal.dialog wire:model.defer="showEditModal">
            <x-slot name="title">Compose Update Email</x-slot>
            <x-slot name="content">
                <div class=" space-y-2 ">
                    <x-input.group for="email" label="From" width="full">
                        <x-input.text wire:model='email' type="text" placeholder="Enter Sender's Email"
                            class="form-input w-full rounded" />
                    </x-input.group>
                    <x-input.group for="subject" label="Subject" width="full">
                        <x-input.text wire:model='subject' type="text" placeholder="Enter the subject of the email"
                            class="form-input w-full rounded" />
                    </x-input.group>
                    <x-input.group for="content" label="Content" width="full">
                        <x-input.textarea wire:model='content' type="text" placeholder="Enter the message here"
                            class="form-input w-full rounded" />
                    </x-input.group>
    
            </x-slot>
    
            <x-slot name="footer">
                <x-button.secondary>Cancel</x-button.secondary>
                
                <x-button.primary class="p-2 rounded-lg">Save</x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </div>
</x-pages.dash-standard-template>