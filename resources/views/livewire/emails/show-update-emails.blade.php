<x-pages.dash-standard-template>
    <div class="flex-col space-y-4">
        <div class="flex justify-between items-center">
            <div>
                <x-pages.title.left>Notification Emails</x-pages.title.left>
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
                    placeholder="Search subject .."></x-input.text>
            </div>

            <div class="mr-2 space-x-2 flex items-center">
                @if($selected)
                <x-dropdown label="Bulk Actions">
                        <x-dropdown.item type='button' wire:click='deleteSelected' class="flex items-center space-x-2">
                            <x-icons.trash class="text-cool-gray-200" /><span>Delete</span>
                        </x-dropdown.item>
                </x-dropdown>
                @endif
                <x-button.primary wire:click="create"><x-icons.plus /> <span>Add New</span></x-button.primary>
            </div>
        </div>
        <x-table wire:loading.class="opacity-50">
            <x-slot name="head">
                <x-table.heading class="pr-0 w-8">
                    <!-- <x-input.checkbox></x-input.checkbox> -->
                </x-table.heading>
                <x-table.heading class="w-full" sortable wire:click="sortBy('subject')"
                    :direction="$sortField === 'subject' ? $sortDirection :null"> Subject</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('from')"
                    :direction="$sortField === 'from' ? $sortDirection :null">From</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('status')"
                    :direction="$sortField === 'status' ? $sortDirection :null">Status</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('date')"
                    :direction="$sortField === 'date' ? $sortDirection :null">Date</x-table.heading>
                <x-table.heading></x-table.heading>
            </x-slot>

            <x-slot name="body">
                @forelse($siteUpdates as $siteupdate)
                <x-table.row wire.loading.class.delay="opacity-50" wire:key="row-{{ $siteupdate->id }}">
                    <x-table.cell class="pr-0 w-8">
                        <x-input.checkbox wire:model='selected' value="{{ $siteupdate->id }}"></x-input.checkbox>
                    </x-table.cell>
                    <x-table.cell>{{ $siteupdate->subject }}</x-table.cell>
                    <x-table.cell>{{ $siteupdate->from }}</x-table.cell>
                    <x-table.cell>
                        <span class="font-semibold p-1 rounded bg-{{ $siteupdate->status_color }}-100">{{
                            $siteupdate->status }}</span></x-table.cell>
                    <x-table.cell class="whitespace-nowrap">{{ $siteupdate->date_for_humans}}</x-table.cell>
                    @if($siteupdate->status !== 'Sent')
                    <x-table.cell>
                        <x-button.link wire:click="edit({{ $siteupdate->id }})">Edit</x-button.link>
                    </x-table.cell>
                    @endif
                </x-table.row>
                @empty
                <x-table.row>
                    <x-table.cell colspan="5">
                        <div class="flex space-x-4 justify-center items-center">
                            <x-icons.inbox class="h-8 w-8 text-cool-gray-400" />
                            <span class="font-medium py-8 text-cool-gray-400 text-xl">No Records Found.</span>
                        </div>
                    </x-table.cell>
                </x-table.row>
                @endforelse
            </x-slot>
        </x-table>
        <div>
            {{ $siteUpdates->links() }}
        </div>
    </div>
    <!-- This is the modal form  -->
    <form wire:submit.prevent="save">
        <x-modal.dialog wire:model.defer="showEditModal">
            <x-slot name="title">Compose Update Email</x-slot>
            <x-slot name="content">
                <div class=" space-y-2 ">
                    <x-input.group for="from" label="From" width="full" :error="$errors->first('editing.from')">
                        <x-input.text wire:model="editing.from" type="text" placeholder="Enter Sender's Email"
                            class="form-input w-full rounded" />
                    </x-input.group>
                    <x-input.group for="subject" label="Subject" width="full"
                        :error="$errors->first('editing.subject')">
                        <x-input.text wire:model='editing.subject' type="text"
                            placeholder="Enter the subject of the email" class="form-input w-full rounded" />
                    </x-input.group>
                    <x-input.group for="slug" label="Slug" width="full" :error="$errors->first('editing.slug')">
                        <x-input.text wire:model='editing.slug' type="text" placeholder="Enter the slug of the subject"
                            class="form-input w-full rounded" />
                    </x-input.group>
                    <x-input.group for="content" label="Content" width="full"
                        :error="$errors->first('editing.content')">
                        <x-input.rich-text wire:model='editing.content' unique='editing.content' rows=10 type="text"
                            placeholder="Enter the message here" class="form-input w-full rounded" />
                    </x-input.group>

            </x-slot>

            <x-slot name="footer">
                <div class="space-x-4">
                    <x-button.secondary wire:click="$set('showEditModal',false)">Cancel</x-button.secondary>

                    <x-button.primary type='submit' class="p-2 rounded-lg">Save</x-button.primary>
                </div>


            </x-slot>
        </x-modal.dialog>
    </form>
    </div>
</x-pages.dash-standard-template>