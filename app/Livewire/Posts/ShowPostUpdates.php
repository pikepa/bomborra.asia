<?php

namespace App\Livewire\Posts;

use App\Models\SiteUpdate;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPostUpdates extends Component
{
    use WithPagination;

    public $sortDirection = 'desc';

    public $showModal = false;

    public SiteUpdate $editing;

    public $selected = [];

    public $search = '';

    public $showAlert = false;

    public $sortField;

    protected $queryString = ['sortField', 'sortDirection'];

    public function paginationView()
    {
        return 'pagination';
    }

    public function mount()
    {
        $this->sortField = 'update_date';
        $this->editing = $this->makeBlankTransaction();
    }

    public function render()
    {
        return view('livewire.posts.show-post-updates', [
            'siteUpdates' => SiteUpdate::filtertitle($this->search)
                ->with('owner', 'post')
                ->orderBy($this->sortField, $this->sortDirection)->paginate(9),
        ]);
    }

    // public function rules()
    // {
    //     return [
    //         'editing.from' => 'email|required',
    //         'editing.date' => 'required',
    //         'editing.subject' => 'required|min:6|max:150',
    //         // 'editing.content' => 'required|min:10',
    //         // 'editing.slug' => 'required',
    //         'editing.status' => 'required:in:'.collect(SiteUpdate::STATUSES)->keys()->implode(','),
    //     ];
    // }

    public function updatedSearch(&$value)
    {
        if ($value == '') {
            $value = null;
        }
        $this->resetPage();
    }

    public function deleteSelected()
    {
        $siteupdates = SiteUpdate::whereKey($this->selected);
        $siteupdates->delete();

        $recs = count($this->selected);
        $this->selected = [];

        session()->flash('message', $recs.' Notification successfully deleted.');
        session()->flash('alertType', 'success');
    }

    public function createEmail()
    {
        $array = implode('-', $this->selected);

        // By clicking the drop down, I want to open a modal to Capture email.
        // then create jobs from within this component
        redirect()->route('email.compose', ['selected' => $array]);

    }

    public function openModal()
    {
        $this->showModal = true;
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

    public function makeBlankTransaction()
    {
        return SiteUpdate::make(['date' => Carbon::now(), 'status' => 'Draft', 'from' => 'pikepeter@gmail.com']);
    }

    // public function create()
    // {
    //     if ($this->editing->getKey()) {
    //         $this->editing = $this->makeBlankTransaction();
    //     }
    //     $this->showEditModal = true;
    // }

    public function resetBanner()
    {
        $this->showAlert = false;
        session()->flash('message', '');
        session()->flash('alertType', '');
    }
}
