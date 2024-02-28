<?php

namespace App\Http\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;

class DisplayPostGallery extends Component
{
    public $mediaItems;

    public $post;

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->mediaItems = $post->getMedia('photos');
    }

    public function render()
    {
        return view('livewire.posts.display-post-gallery');
    }
}
