<?php

declare(strict_types=1);

namespace App\Livewire\Menus;

use App\Models\Category;
use Livewire\Component;

final class MenuTop extends Component
{
    public function render()
    {
        return view('livewire.menus.menu-top', [
            'm_categories' => Category::where('type', 'main')->get(),
            's_categories' => Category::where('type', 'sub')->get(),
        ]);
    }
}
