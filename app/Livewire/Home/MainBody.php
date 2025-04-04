<?php

declare(strict_types=1);

namespace App\Livewire\Home;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

final class MainBody extends Component
{
    use WithPagination;

    public $channel;

    public $postCount;

    public $posts;

    public $taglessBody;

    public function mount($channel)
    {
        $this->channel = $channel;
    }

    public function render()
    {
        $this->posts = Post::published()
            ->where('channel_id', $this->channel->id)
            ->orderBy('published_at', 'desc')
            ->get();

        $this->postCount = $this->posts->count();

        return view('livewire.home.main-body');
    }
}
