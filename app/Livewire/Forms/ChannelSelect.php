<?php

namespace App\Livewire\Forms;

use App\Models\Channel;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class ChannelSelect extends Component
{
    public $queryChannels;   // all channels for select dropdown

    #[Modelable]
    public $channel_id;

    public function mount($chan_id = null)
    {
        if ($chan_id != null) {
            $this->channel_id = $chan_id;
        }
        $this->queryChannels = Channel::whereStatus(1)->orderBy('sort', 'asc')->get();

        // $this->queryChannels = Cache::rememberForever('quertChannels', function () {
        //     return Channel::orderBy('name', 'desc')->get();
        // });
    }

    public function render()
    {
        return view('livewire.forms.channel-select', $this->queryChannels);
    }
}
