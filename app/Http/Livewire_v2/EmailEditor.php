<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EmailEditor extends Component
{
    public $email;

    public $content;

    public $subject;

    public function render()
    {
        return view('livewire.email-editor');
    }
}
