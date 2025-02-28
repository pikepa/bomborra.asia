<?php

declare(strict_types=1);

namespace App\Livewire\Menus;

use App\Models\Category;
use Livewire\Component;

final class MenuBottom extends Component
{
    public function render()
    {
        return view('livewire.menus.menu-bottom', [
            'categories' => Category::where('type', 'sub')->get(),
        ]);
    }
}
