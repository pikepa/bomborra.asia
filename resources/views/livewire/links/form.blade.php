<div class="p-4 space-y-6 rounded-lg border-2">
    <!-- link Name -->
    <x-input.group for="title" label="Title" width="full">
        <x-input.text wire:model='title' type="text" class="form-input w-full rounded" value="{{$title}}">
        </x-input.text>
    </x-input.group>

    <!-- link URL -->
    <x-input.group for="url" label="URL" width="full">
        <x-input.text wire:model='url' type="text" class="form-input w-full rounded" value="{{$url}}">
        </x-input.text>
    </x-input.group>

    <div class="flex flex-row justify-between">
            <!-- link position -->
            <x-input.group for="position" label="Position" >
                <x-input.text wire:model='position' type="text" class="form-input w-full rounded" value="{{$position}}">
                </x-input.text>
            </x-input.group>
        
            <!-- link Sort -->
            <x-input.group for="sort" label="Sort" >
                <x-input.text wire:model='sort' type="text" class="form-input w-full rounded" value="{{$sort}}">
                </x-input.text>
            </x-input.group>
    </div>

    <!-- link Status -->
    <div>
        <x-input.group for="status" label="Active Status" width="full">
            <input wire:model='status' type="checkbox" class="ml-2">
        </x-input.group>
    </div>

    <!-- this is the save button -->
    <div class="flex justify-around">
        <div>
            <button type="submit" class="w-28 p-2 rounded-lg bg-green-500">
                Save
            </button>
        </div>

        <div>
            <button wire:click='cancel' class="w-28 p-2 rounded-lg bg-orange-500">
                Cancel
                </a>
            </button>
        </div>
    </div>

</div>