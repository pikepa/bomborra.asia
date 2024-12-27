<div>
    <x-forms.card title="Compose Update Email">
        <div class=" space-y-2 ">
            <x-input.group for="email" label="From" width="full">
                <x-input.text wire:model.live='email' type="text" placeholder="Enter Sender's Email"
                    class="form-input w-full rounded" />
            </x-input.group>
            <x-input.group for="subject" label="Subject" width="full">
                <x-input.text wire:model.live='subject' type="text" placeholder="Enter the subject of the email"
                    class="form-input w-full rounded" />
            </x-input.group>
            <x-input.group for="content" label="Content" width="full">
                <x-input.textarea wire:model.live='content' type="text" placeholder="Enter the message here"
                    class="form-input w-full rounded" />
            </x-input.group>
            <div >
                <button wire:click="showAddForm" type="button"
                  class="mt-4 inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                  <i class="fa-solid fa-plus"></i>&nbsp; Add Link</button>
            </div>
            <div >
                <button wire:click="showAddForm" type="button"
                  class="mt-4 inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                  <i class="fa-solid fa-plus"></i>&nbsp; Add Subscribers</button>
            </div>
    </x-forms.card>
</div>