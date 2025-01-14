<?php

declare(strict_types=1);

namespace App\Livewire\Posts;

use App\Events\PostPublished;
use App\Livewire\Forms\PostForm;
use App\Models\Post;
use Carbon\Carbon;
use Livewire\Component;

class EditPost extends Component
{
    public PostForm $form;

    public function mount(string $slug, string $origin)
    {
        $this->form->origin = $origin;
        $post = Post::where('slug', $slug)->first();
        $this->form->setPost($post);
    }

    public function render()
    {
        return view('livewire.posts.edit-post');
    }

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'category_selected',
        'channel_selected',
        'body_value_updated',
        'photoAdded' => '$refresh',
        'editPost' => 'render',
    ];

    public function body_value_updated($value)
    {
        $this->form->body = $value;
    }
    // protected $rules =
    //     [
    //         'title' => 'required|min:10|max:250',
    //         'slug' => 'required',
    //         'body' => 'required|min:20',
    //         'meta_description' => 'required|min:20|max:500',
    //         'is_in_vault' => 'required|boolean',
    //         'author_id' => 'required|integer',
    //         'category_id' => 'required|integer',
    //         'channel_id' => 'required|integer',
    //         'published_at' => '',
    //         'cover_image' => 'nullable|url',
    //     ];

    public function populate()
    {
        $this->form->body = $value;
    }

    public function updatedNewImage()
    {
        $this->validate(['newImage' => 'image|max:5000']);
    }

    public function category_selected($category_id)
    {
        $this->form->category_id = $category_id;
    }

    public function channel_selected($channel_id)
    {
        $this->form->channel_id = $channel_id;
    }

    public function update()
    {
        if (! $this->form->published_at) {
            $this->form->published_at = null;
        }
        $this->form->update();
        if ($this->form->origin === 'P') {
            return redirect()->to('/posts/'.$this->form->post->slug);
        } else {
            return redirect()->to('/dashboard/posts');
        }
    }

    public function cancel()
    {
        if ($this->form->origin === 'P') {
            return redirect()->to('/posts/'.$this->form->post->slug);
        } else {
            return redirect()->to('/dashboard/posts');
        }
    }

    public function publishPost()
    {
        if (! $this->form->temp_published_at) {
            $this->form->published_at = Carbon::now()->format('Y-m-d');
        } else {
            $this->form->published_at = Carbon::parse($this->form->temp_published_at);
        }
        $this->update();
        $postfound = $this->form->post->refresh();
        PostPublished::dispatch($postfound, Carbon::now());
        // $this->dispatch('refreshcomponent');
    }

    public function unpublishPost()
    {
        $this->form->post->published_at = Carbon::make(null);
        $this->form->post->update();
        $this->form->post->siteUpdate()->delete();

        return redirect()->to('/posts/'.$this->form->post->slug);
    }
}
