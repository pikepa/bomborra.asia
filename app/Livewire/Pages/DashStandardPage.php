<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class DashStandardPage extends Component
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
