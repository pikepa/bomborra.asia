<?php

namespace App\Http\Livewire\Menus;

use App\Models\Category;
use Livewire\Component;

class MenuBottom extends Component
{
    public function render()
    {
        return view('livewire.menus.menu-bottom', [
            'categories' => Category::where('type', 'sub')->get(),
        ]);
    }
}
