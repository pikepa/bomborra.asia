<?php

namespace App\Http\Livewire\Subscriber;

use App\Models\Subscriber;
use Livewire\Component;
use Livewire\WithPagination;

class ManageSubscribers extends Component
{
    use WithPagination;

    public $showAlert = false;

    public $selected = [];

    public $sortDirection = 'desc';

    public $sortField;

    public $search = '';

    public $searchField = 'name';

    protected $queryString = ['sortField', 'sortDirection'];

    public function paginationView()
    {
        return 'pagination';
    }

    public function mount()
    {
        $this->sortField = 'created_at';
    }

    public function render()
    {
        return view('livewire.subscriber.manage-subscribers', [
            'subscribers' => Subscriber::search('name', $this->search)
                ->orderBy($this->sortField, $this->sortDirection)->paginate(9),
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

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
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
