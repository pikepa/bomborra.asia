<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
final class DashStandardPage extends Component
{
    public $show = 'dash';

    public function mount($page = 'dash')
    {
        if ($page) {
            $this->show = $page;
        }
    }

    public function render()
    {
        return view('livewire.pages.dash-standard-page');
    }

    public function setShow($item)
    {
        $this->show = $item;
    }
}
