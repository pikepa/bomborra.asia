<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;

final class Signup extends Component
{
    public $showModal = false;

    public function openModal()
    {
        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.signup');
    }
}
