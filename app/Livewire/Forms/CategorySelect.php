<?php

namespace App\Livewire\Forms;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class CategorySelect extends Component
{
    public $queryCategories;

    #[Modelable]
    public $category_id;

    public function mount($cat_id = null)
    {
        if ($cat_id != null) {
            $this->category_id = $cat_id;
        }
        $this->queryCategories = Cache::rememberForever('queryCategories', function () {
            return Category::orderBy('name', 'asc')->get();
        });
    }

    public function render()
    {
        return view('livewire.forms.category-select', $this->queryCategories);
    }

    //     public function updated($category_id)
    //     {
    //         $this->dispatch('category_selected',category_id:$this->category_id);
    //     }
}
