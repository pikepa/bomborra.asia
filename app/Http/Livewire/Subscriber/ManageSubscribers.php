<?php

namespace App\Http\Livewire\Subscriber;

use App\Models\Subscriber;
use Livewire\Component;
use Livewire\WithPagination;

class ManageSubscribers extends Component
{
    use WithPagination;

    public $search;

    public $isNotValidated = false;

    public $showTable = true;

    public $showEditForm = false;

    public $showAddForm = false;

    public $showAlert = false;

    public $sortField;

    public function paginationView()
    {
        return 'pagination';
    }

    public function render()
    {
        return view('livewire.subscriber.manage-subscribers', [
            'subscribers' => Subscriber::when($this->search != '', function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            })
                ->when($this->isNotValidated == true, function ($query) {
                    $query->where('validated_at', null);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(9),
        ]);
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
