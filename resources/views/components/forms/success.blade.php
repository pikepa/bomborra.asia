<div class="flex justify-end">
    @if(session('alertType') == 'success')
    <div class="flex justify-around items-center bg-green-700 rounded-lg p-2 pl-4 text-gray-100 text-xl space-x-4">
        <div>
            <i class="fa fa-check-circle  font-light text-gray-200"></i>
        </div>
        <div>
            {{ session('message') }}
        </div>  
        <div>
            <button wire:click="resetBanner">X</button>
        </div>
    </div>
    @endif
    @if(session('alertType') == 'error')
    <div class="flex w-1/2 bg-red-700 rounded-lg p-4 text-gray-100 text-xl space-x-4">
        <div>
            <i class="fa fa-check-circle  font-light text-gray-200"></i>
        </div>
        <div>
            {{ session('message') }}
        </div>
        <div>
            <button wire:click="resetBanner">X</button>
        </div>
    </div>
    @endif
</div>