<?php

namespace App\Http\Livewire\Emails;

use App\Models\SiteUpdate;
use Livewire\Component;
use Livewire\WithPagination;

class ShowUpdateEmails extends Component
{
    use WithPagination;

    public $showEditModal = false;

    public SiteUpdate $editing;

    public function rules()
    {
        return [
            'editing.from' => 'email|required',
            'editing.subject' => 'required|min:6|max:150',
            'editing.content' => 'required|min:10',
            'editing.slug' => 'required',
            'editing.status' => 'required:in:'.collect(SiteUpdate::STATUSES)->keys()->implode(','),
        ];
    }

    public function mount()
    {
        $this->editing = SiteUpdate::make(['date' => now()]);
    }

    public function render()
    {
        return view('livewire.emails.show-update-emails', [
            'siteUpdates' => SiteUpdate::paginate(9),
        ]);
    }

    public function create()
    {
        $this->showEditModal = true;
    }

    public function edit(SiteUpdate $siteupdate)
    {
        $this->editing = $siteupdate;
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();
        $this->editing->save();
        $this->showEditModal = false;

    }
}
