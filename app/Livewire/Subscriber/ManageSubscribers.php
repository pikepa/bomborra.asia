<?php

namespace App\Livewire\Subscriber;

use App\Jobs\Subscribers\SendWebUpdate;
use App\Livewire\DataTable\WithBulkActions;
use App\Livewire\DataTable\WithSorting;
use App\Models\Subscriber;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ManageSubscribers extends Component
{
    use WithBulkActions, WithPagination, WithSorting;

    public $searchField = 'name';

    public $showAlert = false;

    public $showFilters = false;

    public $showBulkActions = false;

    public $filters = [
        'search' => '',
        'status' => '',
        'val-date-min' => null,
        'val-date-max' => null,
        'create-date-min' => null,
        'create-date-max' => null,
    ];

    protected $queryString = ['sortField', 'sortDirection'];

    public function paginationView()
    {
        return 'pagination';
    }

    public function deleteSelected()
    {
        $this->selectedRowsQuery->delete();

        $recs = count($this->selected);
        $this->selected = [];

        session()->flash('message', $recs.' Subscribers successfully deleted.');
        session()->flash('alertType', 'success');
    }

    public function validateSelected()
    {
        $this->selectedRowsQuery->update(['validated_at' => Carbon::now()]);

        $recs = count($this->selected);
        $this->selected = [];

        session()->flash('message', $recs.' Subscribers successfully validated.');
        session()->flash('alertType', 'success');
    }

    public function sendEmails()
    {
        foreach ($this->selected as $value) {
            $subscriber = Subscriber::find($value);
            dispatch(new SendWebUpdate($subscriber));  //this is a job....
        }

        $recs = count($this->selected);
        $this->selected = [];

        session()->flash('message', $recs.' Subscriber email jobs submitted.');
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

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function getRowsQueryProperty()
    {
        $query = Subscriber::query()
            ->when($this->filters['status'], fn ($query, $status) => $status == 'VAL' ? $query->where('validated_at', '<>', null) : $query->whereNull('validated_at'))
            ->when($this->filters['search'], fn ($query, $search) => $query->where('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%'))
            ->when($this->filters['val-date-min'], fn ($query, $date) => $query->where('validated_at', '>=', Carbon::parse($date)))
            ->when($this->filters['val-date-max'], fn ($query, $date) => $query->where('validated_at', '<=', Carbon::parse($date)))
            ->when($this->filters['create-date-min'], fn ($query, $date) => $query->where('created_at', '>=', Carbon::parse($date)))
            ->when($this->filters['create-date-max'], fn ($query, $date) => $query->where('created_at', '<=', Carbon::parse($date)));

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(10);
    }

    public function mount()
    {
        $this->sortField = 'created_at';
    }

    public function render()
    {
        if ($this->selectAll) {
            $this->selected = $this->rows->pluck('id')->map(fn ($id) => (string) $id);
        }

        return view('livewire.subscriber.manage-subscribers', [
            'subscribers' => $this->rows,
        ]);
    }
}
