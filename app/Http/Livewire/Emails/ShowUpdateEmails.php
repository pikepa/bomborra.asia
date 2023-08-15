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

    public $rules = [
        '$editing.email' => 'email|required',
        '$editing.subject' => 'required|min:6|max:150',
        '$editing.content' => 'required|min:10',
        '$editing.slug' => 'required',
        '$editing.status' => 'required',
    ];

    public function render()
    {
        return view('livewire.emails.show-update-emails', [
            'siteUpdates' => SiteUpdate::paginate(5),
        ]);
    }

    public function create()
    {
        $this->showEditModal = true;
    }

    public function edit()
    {
        $this->showEditModal = true;
    }
}
