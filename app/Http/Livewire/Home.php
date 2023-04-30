<?php

namespace App\Http\Livewire;

use App\Models\Channel;
use Livewire\Component;

class Home extends Component
{
    public $channels = [];

    public function render()
    {
        $channels = Channel::where('status', true)
            ->orderBy('sort', 'asc')->get();

        return view('livewire.home')->with(['channels' => $channels]);
    }
}
