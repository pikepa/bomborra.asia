<?php

namespace App\Http\Livewire\Posts;

use App\Models\Channel;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShowChannelPosts extends Component
{
    use WithPagination;

    public $channel;

    public function mount($chan_slug)
    {
        $this->channel = Channel::where('slug', $chan_slug)->first();
    }

    public function render()
    {
        if (Auth::check()) {
            return view(
                'livewire.posts.show-channel-posts',
                ['posts' => Post::with('author')->where('channel_id', $this->channel->id)
                    ->orderBy('published_at', 'desc')->paginate(5), ]
            );
        } else {
            return view(
                'livewire.posts.show-channel-posts',
                ['posts' => Post::published()->with('author')->where('channel_id', $this->channel->id)
                    ->orderBy('published_at', 'desc')->paginate(5), ]
            );
        }
    }
}
