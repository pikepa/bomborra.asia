<?php

declare(strict_types=1);

namespace App\Livewire\Posts;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class ShowPost extends Component
{
    public $post;

    public $post_id;

    public $showEditForm = false;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount($slug)
    {
        if (Auth::check()) {
            $post = Post::where('slug', $slug)->first();
        } else {
            $post = Post::published()->where('slug', $slug)->first();
            if ($post === null) {
                return redirect('/login')->with('status', 'Not Authorized!');
            }
        }
        $this->post = $post;
    }

    public function render()
    {
        return view('livewire.posts.show-post');
    }

    public function publish($date = null)
    {
        $this->post->publish($date);
        // return redirect()->to('/posts/' . $this->post->slug);
        $this->dispatch('refreshComponent');
    }
    // public function editPost()
    // {
    //     // return redirect()->to('/dashboard/posts/'. $this->post->id );
    // }
}
