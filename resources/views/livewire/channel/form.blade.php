<div class="p-4 space-y-6 rounded-lg border-2">
    <!-- channel Name -->
    <x-input.group for="name" label="Channel" width="full">
        <x-input.text wire:model='name' type="text" class="form-input w-full rounded">
        </x-input.text>
    </x-input.group>

    <!-- channel Sort -->
    <x-input.group for="sort" label="Sort" width="full">
        <x-input.text wire:model='sort' type="text" class="form-input w-full rounded" value="{{$sort}}">
        </x-input.text>
    </x-input.group>

    <!-- channel Status -->
    <div>
        <x-input.group for="status" label="Active Status" width="full">
            <input type="checkbox" wire:model="status"  class="ml-2">
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