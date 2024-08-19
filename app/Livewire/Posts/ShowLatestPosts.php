<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ShowLatestPosts extends Component
{
    use WithPagination;

    public $period = 6;

    public function updatedPeriod()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view(
            'livewire.posts.show-latest-posts',
            ['posts' => Post::where('published_at', '>', Carbon::now()->subMonth($this->period))
                ->orderBy('published_at', 'desc')->paginate(12), ]
        );
    }
}
