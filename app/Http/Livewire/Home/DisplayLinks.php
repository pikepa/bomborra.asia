<?php

namespace App\Http\Livewire\Home;

use App\Models\Link;
use Livewire\Component;

class DisplayLinks extends Component
{
    public $links = [];

    public $position;

    public function mount($position = 'RIGHT')
    {
        $this->position = $position;
    }

    public function render()
    {
        $this->links = Link::wherePosition($this->position)
            ->whereStatus(true)->orderBy('sort', 'asc')->get();

        return <<<'blade'
            <div>
            <ul class="list-disc ml-4 p-2">
                @if($links)
                    @foreach($links as $link)
                        <li><a href={{$link->url}} target="_blank">{{$link->title}}</a></li>
                    @endforeach
                @endif
            </ul>
            </div>

        blade;
    }
}
