<?php

namespace App\Http\Livewire\Emails;

use App\Models\SiteUpdate;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ShowUpdateEmails extends Component
{
    use WithPagination;

    public $sortDirection = 'desc';

    public $showEditModal = false;

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
        $this->sortField = 'date';
        $this->editing = $this->makeBlankTransaction();
    }

    public function render()
    {
        return view('livewire.emails.show-update-emails', [
            'siteUpdates' => SiteUpdate::search('subject', $this->search)
                ->orderBy($this->sortField, $this->sortDirection)->paginate(9),
        ]);
    }

    public function rules()
    {
        return [
            'editing.from' => 'email|required',
            'editing.date' => 'required',
            'editing.subject' => 'required|min:6|max:150',
            'editing.content' => 'required|min:10',
            'editing.slug' => 'required',
            'editing.status' => 'required:in:'.collect(SiteUpdate::STATUSES)->keys()->implode(','),
        ];
    }

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

        session()->flash('message', $recs.' Notification Emails successfully deleted.');
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

    public function makeBlankTransaction()
    {
        return SiteUpdate::make(['date' => Carbon::now(), 'status' => 'Draft', 'from' => 'pikepeter@gmail.com']);
    }

    public function create()
    {
        if ($this->editing->getKey()) {
            $this->editing = $this->makeBlankTransaction();
        }
        $this->showEditModal = true;
    }

    public function edit(SiteUpdate $siteupdate)
    {
        if ($this->editing->isNot($siteupdate)) {
            $this->editing = $siteupdate;
        }
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();
        $this->editing->save();
        $this->showEditModal = false;
    }

    public function resetBanner()
    {
        $this->showAlert = false;
        session()->flash('message', '');
        session()->flash('alertType', '');
    }
}
