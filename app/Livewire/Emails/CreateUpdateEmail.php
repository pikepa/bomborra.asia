<?php

declare(strict_types=1);

namespace App\Livewire\Emails;

use App\Livewire\Posts\ShowPostUpdates;
use App\Models\EmailUpdate;
use App\Models\SiteUpdate;
use Carbon\Carbon;
use Livewire\Component;

final class CreateUpdateEmail extends Component
{
    public $selected = [];

    public $notifications;

    public EmailUpdate $createdEmail;

    public $from_email;

    public $subject;

    public function mount($selected = null)
    {
        $this->selected = explode('-', $selected);
        $date = Carbon::now()->format('D M d, Y');
        $this->subject = 'Updates from '.env('APP_NAME').' as at '.$date;
        $this->from_email = auth()->user()->email;
        $this->createdEmail = new EmailUpdate;
    }

    public function render()
    {
        $this->notifications = SiteUpdate::with('post', 'owner')->whereIn('id', $this->selected)->get();

        return view('livewire.emails.create-update-email');
    }

    public function goBack()
    {
        $this->redirect(ShowPostUpdates::class);
    }
}
