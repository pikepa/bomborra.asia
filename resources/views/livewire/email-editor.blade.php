<div>
    <x-forms.card title="Compose Update Email">
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
        </div>
    </x-forms.card>
</div>