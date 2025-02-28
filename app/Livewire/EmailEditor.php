<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\EmailUpdate;
use Carbon\Carbon;
use Livewire\Component;

final class EmailEditor extends Component
{
    public EmailUpdate $createdEmail;

    public $from_email;

    public $selected = [];

    public $content;

    public $subject;

    public function mount($selected = null)
    {
        $date = Carbon::now()->format('D M d, Y');
        $this->selected = $selected;
        $this->subject = 'Updates from '.env('APP_NAME').' as at '.$date;
        $this->from_email = auth()->user()->email;
        $this->createdEmail = new EmailUpdate;
    }

    public function render()
    {
        return view('livewire.email-editor');
    }

    public function save() {}
}
