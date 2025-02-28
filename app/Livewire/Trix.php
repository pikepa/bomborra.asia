<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;

final class Trix extends Component
{
    public $value;

    public $trixId;

    public function mount($value = '')
    {
        $this->value = $value;
        $this->trixId = 'trix-'.uniqid();
    }

    public function updatedValue($value)
    {
        dd($value);
    }

    public function render()
    {
        return view('livewire.trix');
    }
}
