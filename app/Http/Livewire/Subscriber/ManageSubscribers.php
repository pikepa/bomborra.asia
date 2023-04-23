<?php

namespace App\Http\Livewire\Subscriber;

use App\Models\Subscriber;
use Livewire\Component;

class ManageSubscribers extends Component
{
    public $subscribers;

    public $search;

    public $selectInvalid = false;

    public $showTable = true;

    public $showEditForm = false;

    public $showAddForm = false;

    public $showAlert = false;

    public function render()
    {
        $this->subscribers = Subscriber::search('name', $this->search)->orderBy('created_at', 'desc')->get();

        return view('livewire.subscriber.manage-subscribers');
    }

    /*
      Switching Forms on Master Screen
    */
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

    public function delete($id)
    {
        $post = Subscriber::findOrFail($id);
        $post->delete();
        $this->showAlert = true;

        session()->flash('message', ' Subscriber Successfully deleted.');
        session()->flash('alertType', 'success');
    }

    public function cancel()
    {
        $this->resetBanner();
        $this->showTable();
    }

    public function resetBanner()
    {
        $this->showAlert = true;

        session()->flash('message', '');
        session()->flash('alertType', '');
    }
}
