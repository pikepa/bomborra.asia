<?php

namespace App\Livewire\Channel;

use App\Models\Channel;
use Illuminate\Support\Str;
use Livewire\Component;

class ManageChannels extends Component
{
    public $name = '';

    public $slug = '';

    public $status = false;

    public $sort = '';

    public $channels;

    public $channel_id;

    public $showTable = true;

    public $showEditForm = false;

    public $showAddForm = false;

    public $showAlert = false;

    protected $rules = [
        'name' => 'required|min:6|max:50',
        'slug' => 'required',
        'status' => 'required|boolean',
        'sort' => 'required|integer',
    ];

    public function render()
    {
        $this->channels = Channel::orderBy('sort', 'asc')->get();

        return view('livewire.channel.manage-channels');
    }
    //  Switching Forms on Master Screen

    public function showAddForm()
    {
        $this->showTable = false;
        $this->showEditForm = false;
        $this->showAddForm = true;
    }

    public function showEditForm()
    {
        $this->showTable = false;
        $this->showEditForm = true;
        $this->showAddForm = false;
    }

    public function showTable()
    {
        $this->showTable = true;
        $this->showEditForm = false;
        $this->showAddForm = false;
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function create()
    {
        $this->showAddForm();
    }

    public function save()
    {
        $channelData = $this->validate();

        Channel::create($channelData);

        $this->reset();
        $this->showTable();

        session()->flash('message', 'Channel Successfully added.');
        session()->flash('alertType', 'success');
    }

    public function edit($id)
    {
        $channel = Channel::findOrFail($id);

        $this->name = $channel->name;
        $this->slug = $channel->slug;
        $this->sort = $channel->sort;
        $this->status = $channel->status;
        $this->channel_id = $channel->id;

        $this->showEditForm();
    }

    public function update($id)
    {
        $channel = Channel::find($id);
        $channelData = $this->validate();

        $channel->update($channelData);

        $this->reset();
        $this->showTable();

        session()->flash('message', 'Channel Successfully updated.');
        session()->flash('alertType', 'success');
    }

    public function delete($id)
    {
        $channel = Channel::find($id);

        $channel->delete();

        $this->reset();
        $this->showTable();

        session()->flash('message', 'Channel Successfully deleted.');
        session()->flash('alertType', 'success');
    }

    public function cancel()
    {
        $this->resetBanner();
        $this->showTable();
    }

    public function resetBanner()
    {
        $this->showAlert = false;

        session()->flash('message', '');
        session()->flash('alertType', '');
    }
}
