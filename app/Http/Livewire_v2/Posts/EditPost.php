<?php

declare(strict_types=1);

namespace App\Http\Livewire\Posts;

use App\Events\PostPublished;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;

class EditPost extends Component
{
    public $origin;

    public $post;

    public $channels;

    public $selectedChannel;

    public $categories;

    public $selectedCategory;

    public $post_id;

    public $title;

    public $slug;

    public $body;

    public $is_in_vault = false;

    public $category_id;

    public $channel_id;

    public $author_id;

    public $cover_image;

    public $meta_description;

    public $published_at = null;

    public $temp_published_at = null;

    public function mount(string $slug, string $origin)
    {
        $this->origin = $origin;
        $this->post = Post::where('slug', $slug)->first();
        $this->populate();
    }

    public function render()
    {
        return view('livewire.posts.edit-post');
    }

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'category_selected',
        'channel_selected',
        'photoAdded' => '$refresh',
        'editPost' => 'render',
    ];

    protected $rules =
    [
        'title' => 'required|min:10|max:250',
        'slug' => 'required',
        'body' => 'required|min:20',
        'meta_description' => 'required|min:20|max:500',
        'is_in_vault' => 'required|boolean',
        'author_id' => 'required|integer',
        'category_id' => 'required|integer',
        'channel_id' => 'required|integer',
        'published_at' => '',
        'cover_image' => 'nullable|url',
    ];

    public function populate()
    {
        $this->post_id = $this->post->id;
        $this->title = $this->post->title;
        $this->cover_image = $this->post->cover_image;
        $this->slug = $this->post->slug;
        $this->body = $this->post->body;
        $this->is_in_vault = $this->post->is_in_vault;
        $this->category_id = $this->post->category_id;
        $this->channel_id = $this->post->channel_id;
        $this->selectedCategory = $this->post->category_id;
        $this->selectedChannel = $this->post->channel_id;
        $this->author_id = $this->post->author_id;
        $this->published_at = $this->post->published_at;
        $this->meta_description = $this->post->meta_description;
    }

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    public function updatedNewImage()
    {
        $this->validate(['newImage' => 'image|max:5000']);
    }

    public function category_selected($category_id)
    {
        $this->category_id = $category_id;
    }

    public function channel_selected($channel_id)
    {
        $this->channel_id = $channel_id;
    }

    public function update($id)
    {
        if (! $this->published_at) {
            $this->published_at = null;
        }

        $data = $this->validate();
        $post = Post::findOrFail($id);

        $post->update($data);

        if ($this->origin === 'P') {
            return redirect()->to('/posts/'.$post->slug);
        } else {
            return redirect()->to('/dashboard/posts');
        }
    }

    public function cancel()
    {
        return redirect()->to('/dashboard/posts');
    }

    public function publishPost()
    {
        if (! $this->temp_published_at) {
            $this->published_at = Carbon::now()->format('Y-m-d');
        } else {
            $this->published_at = Carbon::parse($this->temp_published_at);
        }
        $this->update($this->post->id);
        //Event
        // $this->post->publish();
        $postfound = $this->post->refresh();
        PostPublished::dispatch($postfound, Carbon::now());
        $this->dispatch('refreshcomponent');
    }

    public function unpublishPost()
    {
        // $deletepost = Post::find($this->post->id);
        // $deletepost->unpublish();
        // $this->post->refresh();
        $this->published_at = Carbon::make(null);
        $this->update($this->post->id);
        $this->post->siteUpdate()->delete();
    }
}
