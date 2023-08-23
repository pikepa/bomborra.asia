<?php

namespace App\Http\Livewire\Subscriber;

use App\Models\Subscriber;
use Livewire\Component;
use Livewire\WithPagination;

class ManageSubscribers extends Component
{
    use WithPagination;

    public $isNotValidated = false;

    public $showAlert = false;

    public $selected = [];

    public $sortField;

    public $search;

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

    public function deleteSelected()
    {
        $deleteSubscribers = Subscriber::whereKey($this->selected);
        $deleteSubscribers->delete();

        $recs = count($this->selected);
        $this->selected = [];

        session()->flash('message', $recs.' Subscribers successfully deleted.');
        session()->flash('alertType', 'success');
    }

    public function cancel()
    {
        $this->resetBanner();
    }

    public function resetBanner()
    {
        $this->showAlert = true;

        session()->flash('message', '');
        session()->flash('alertType', '');
    }
}
