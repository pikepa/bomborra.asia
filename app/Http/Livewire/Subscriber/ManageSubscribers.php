<?php

namespace App\Http\Livewire\Subscriber;

use App\Jobs\Subscribers\SendWebUpdate;
use App\Models\Subscriber;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ManageSubscribers extends Component
{
    use WithPagination;

    public $sortDirection = 'desc';

    public $searchField = 'name';

    public $showAlert = false;

    public $showFilters = false;

    public $filters = [
        'search' => '',
        'status' => '',
        'val-date-min' => null,
        'val-date-max' => null,
        'create-date-min' => null,
        'create-date-max' => null,
    ];

    public $selectPage = false;

    public $selected = [];

    public $sortField;

    protected $queryString = ['sortField', 'sortDirection'];

    public function paginationView()
    {
        return 'pagination';
    }

    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selected = [];
        } else {
            $this->selected = [];
        }
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

    public function sendEmails()
    {
        foreach ($this->selected as $value) {
            dispatch(new SendWebUpdate($value));
        }

        $recs = count($this->selected);
        $this->selected = [];

        session()->flash('message', $recs.' Subscriber email jobs submitted.');
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

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function mount()
    {
        $this->sortField = 'created_at';
    }

    public function render()
    {
        return view('livewire.subscriber.manage-subscribers', [
            'subscribers' => Subscriber::query()
                ->when($this->filters['status'], fn ($query, $status) => $query->whereNull('validated_at'))
                ->when($this->filters['search'], fn ($query, $search) => $query->where('name', 'like', '%'.$search.'%'))
                ->when($this->filters['val-date-min'], fn ($query, $date) => $query->where('validated_at', '>=', Carbon::parse($date)))
                ->when($this->filters['val-date-max'], fn ($query, $date) => $query->where('validated_at', '<=', Carbon::parse($date)))
                ->when($this->filters['create-date-min'], fn ($query, $date) => $query->where('created_at', '>=', Carbon::parse($date)))
                ->when($this->filters['create-date-max'], fn ($query, $date) => $query->where('created_at', '<=', Carbon::parse($date)))
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(9),
        ]);

    }
}
