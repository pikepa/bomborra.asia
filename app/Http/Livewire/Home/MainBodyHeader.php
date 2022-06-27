<?php

namespace App\Http\Livewire\Home;

use App\Models\Category;
use Livewire\Component;

class MainBodyHeader extends Component
{
    public $category;

    public function mount($cat_id = null)
    {
        if ($cat_id) {
            $this->category = Category::find($cat_id);
        }
    }

    public function render()
    {
        return <<<'blade'
             @if(!$this->category)
                 <div class='flex justify-between items-center'>
                    <div class="w-1/2 text-4xl Font-bold text-teal-900 pb-2">
                        Latest Articles
                    </div>
                    <div class='w-1/2 text-sm text-teal-900 mr-4'>
                        These articles are the latest stories, features, opinion and analysis from journalists around Southeast Asia. 
                    </div>
                </div>
            @else
                <div class='flex justify-between items-center'>
                    <div class="w-1/2 text-4xl Font-bold text-teal-900 pb-2">
                        {{$category->name}}
                    </div>
                    <div class='w-1/2 text-sm text-teal-900 mr-4'>
                        {{$category->description}}
                    </div>
                </div>
            @endif
        blade;
    }
}
