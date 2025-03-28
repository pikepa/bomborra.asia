<?php

declare(strict_types=1);

namespace App\Livewire\Posts;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

final class ShowCategoryPosts extends Component
{
    use WithPagination;

    public $category;

    public function mount($cat_slug)
    {
        $this->category = Category::where('slug', $cat_slug)->first();
    }

    public function render()
    {
        if (Auth::check()) {
            return view(
                'livewire.posts.show-category-posts',
                ['posts' => Post::with('author')->where('category_id', $this->category->id)
                    ->orderBy('published_at', 'desc')->paginate(5), ]
            );
        }

        return view(
            'livewire.posts.show-category-posts',
            ['posts' => Post::published()->with('author')->where('category_id', $this->category->id)
                ->orderBy('published_at', 'desc')->paginate(5), ]
        );
    }
}
