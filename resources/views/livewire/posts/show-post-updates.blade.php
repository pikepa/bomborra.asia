<x-pages.dash-standard-template>
    <div class="flex-col space-y-4">
        <div class="flex justify-between items-center">
            <div>
                <x-pages.title.left>Post Published Notifications</x-pages.title.left>
            </div>
            <div>
                @if (session()->has('message') )
                <x-forms.success />
                @endif
            </div>
        </div>

        <div class="flex justify-between items-center">
            <div class="ml-2 w-1/4">
                <x-input.text wire:model.live="search" class="rounded-md p-2 border-2 border-gray-300"
                    placeholder="Search subject .."></x-input.text>
            </div>

            <div class="mr-2 space-x-2 flex items-center">
                <div>
                    @if($selected)
                    <x-dropdown label="Bulk Actions">
                        <x-dropdown.item type='button' wire:click='deleteSelected' class="flex items-center space-x-2">
                            <x-icons.trash class="text-cool-gray-200" /><span>Delete</span>
                        </x-dropdown.item>
                        <x-dropdown.item type='button' wire:click='createEmail' class="flex items-center space-x-2">
                            <x-icons.plus class="text-cool-gray-200" /><span>Create Email</span>
                        </x-dropdown.item>
                    </x-dropdown>
                    @endif
                </div>
                <x-button.primary class="invisible" wire:click="create"><x-icons.plus /> <span>Add
                        New</span></x-button.primary>
            </div>
        </div>
        <x-table wire:loading.class="opacity-50">
            <x-slot name="head">
                <x-table.heading class="pr-0 w-8">
                    <!-- <x-input.checkbox></x-input.checkbox> -->
                </x-table.heading>
                <x-table.heading sortable wire:click="sortBy('update_date')"
                    :direction="$sortField === 'update_date' ? $sortDirection :null">Date</x-table.heading>
                <x-table.heading class="text-left"> Post Title</x-table.heading>
                <x-table.heading class="text-left">Post Owner</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('status')"
                    :direction="$sortField === 'status' ? $sortDirection :null">Status</x-table.heading>
            </x-slot>

            <x-slot name="body">
                @forelse($siteUpdates as $siteupdate)
                <x-table.row wire.loading.class.delay="opacity-50" wire:key="row-{{ $siteupdate->id }}">
                    <x-table.cell class="pr-0 w-8">
                        <x-input.checkbox wire:model.live='selected' value="{{ $siteupdate->id }}"></x-input.checkbox>
                    </x-table.cell>
                    <x-table.cell>{{ $siteupdate->date_for_humans}}</x-table.cell>
                    <x-table.cell wire:model.live='subject' class="nowrap">{{ $siteupdate->post->title }}</x-table.cell>
                    <x-table.cell>{{ $siteupdate->owner->name }}</x-table.cell>
                    <x-table.cell>
                        <span class="font-semibold p-1 rounded bg-{{ $siteupdate->status_color }}-100">{{
                            $siteupdate->status }}</span></x-table.cell>

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


        <button wire:click="openModal">Open Modal from Livewire</button>
        <div class="flex justify-between items-center pt-4">
            <div class="flex justify-start items-center gap-2 text-sm">
    
                <x-modal wire:model.live="showModal">
                    <x-modal.button>
                        <button type="button" class="underline text-blue-500">
                            terms of service.
                        </button>
                    </x-modal.button>
    
                    <x-modal.panel>
                        <h2 class="text-2xl font-bold text-slate-900">Terms Of Service</h2>
    
                        <div class="mt-5 text-gray-600">
                           <h3 class="font-bold text-lg text-slate-800 mt-4">Acceptance of Terms</h3>
                           <p class="mt-2">By signing up for and using this sweet app, you agree to be bound by these Terms of Service ("Terms"). If you do not agree with these Terms, please do not use the Service.</p>
    
                           <h3 class="font-bold text-lg text-slate-800 mt-4">Changes to Terms</h3>
                           <p class="mt-2">We reserve the right to update and change the Terms at any time without notice. Continued use of the Service after any changes shall constitute your consent to such changes.</p>
    
                           <h3 class="font-bold text-lg text-slate-800 mt-4">Use of the Service</h3>
                           <p class="mt-2">You must provide accurate and complete registration information when you sign up. You are responsible for maintaining the confidentiality of your password and are solely responsible for all activities resulting from its use.</p>
    
                           <h3 class="font-bold text-lg text-slate-800 mt-4">User Content</h3>
                           <p class="mt-2">You are responsible for all content and data you provide or upload to the Service. We reserve the right to remove content deemed offensive, illegal, or in violation of these Terms or any other policy.</p>
    
                           <h3 class="font-bold text-lg text-slate-800 mt-4">Limitation of Liability</h3>
                           <p class="mt-2">The Service is provided "as is". We make no warranties, expressed or implied, and hereby disclaim all warranties, including without limitation, implied warranties of merchantability, fitness for a particular purpose, or non-infringement.</p>
    
                           <h3 class="font-bold text-lg text-slate-800 mt-4">Termination</h3>
                           <p class="mt-2">We reserve the right to suspend or terminate your account at any time for any reason, with or without notice.</p>
    
                           <h3 class="font-bold text-lg text-slate-800 mt-4">Governing Law</h3>
                           <p class="mt-2">These Terms shall be governed by the laws of the land of fairy tale creatures, without respect to its conflict of laws principles.</p>
    
                           <h3 class="font-bold text-lg text-slate-800 mt-4">Miscellaneous</h3>
                           <p class="mt-2">If any provision of these Terms is deemed invalid or unenforceable, the remaining provisions shall remain in effect.</p>
    
                           <h3 class="font-bold text-lg text-slate-800 mt-4">Contact</h3>
                           <p class="mt-2">For any questions regarding these Terms, please contact us at dontcontactus@ever.com.</p>
                        </div>
                    </x-modal.panel>
                </x-modal>
            </div>
    
        </div>




</x-pages.dash-standard-template>