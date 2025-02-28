<?php

declare(strict_types=1);

namespace App\Livewire\Posts\Index;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Posts')]
final class Page extends Component
{
    public function render()
    {
        return view('livewire.posts.index.page');
    }
}
