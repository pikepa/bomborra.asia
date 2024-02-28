<?php

namespace App\Http\Livewire\Images;

use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PinImages extends Component
{
    public $image_id;

    public $pinned = true;

    public function mount($image)
    {
        $this->image_id = $image->id;
        $this->pinned = $image->getCustomProperty('pinned', false);
    }

    public function render()
    {
        return <<<'blade'
            <div>
                @if($pinned)
                <div class="pt-1 text-green-600 font-bold dark:text-sky-400">
                    <button wire:click='setUnpinned' ><i class="fa fa-thumb-tack" aria-hidden="true"></i></button>
                </div>
                @else
                <div class="pt-1 text-red-600 font-bold dark:text-sky-400">
                    <button wire:click='setPinned' ><i class="fa fa-thumb-tack" aria-hidden="true"></i></button>
                </div>
                @endif
            </div>
        blade;
    }

    public function setPinned()
    {
        $this->pinned = true;
        $image = Media::findorfail($this->image_id);
        $image->setCustomProperty('pinned', true);
        $image->update();
    }

    public function setUnpinned()
    {
        $this->pinned = false;
        $image = Media::findorfail($this->image_id);
        $image->setCustomProperty('pinned', false);
        $image->update();
    }
}
