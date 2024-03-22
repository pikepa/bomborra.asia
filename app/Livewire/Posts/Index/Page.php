<?php

namespace App\Livewire\Posts\Index;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Posts')]
class Page extends Component
{
    public function render()
    {
        return view('livewire.posts.index.page');
    }
}
