<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\Post;
use Illuminate\Support\Str;
use Livewire\Form;

final class PostForm extends Form
{
    public ?Post $post;

    public $origin;

    public $channels;

    public $selectedChannel;

    public $categories;

    public $selectedCategory;

    public $post_id;

    public $title;

    public $slug;

    public $body = '';

    public $meta_description;

    public $is_in_vault = false;

    public $category_id;

    public $channel_id;

    public $author_id;

    public $cover_image;

    public $published_at = null;

    public $temp_published_at = null;

    protected $rules =
        [
            'title' => 'required|min:10|max:250',
            'slug' => 'required',
            'body' => 'required|min:20',
            'meta_description' => 'required|min:10|max:500',
            'is_in_vault' => 'required|boolean',
            'author_id' => 'required|integer',
            'category_id' => 'required|integer',
            'channel_id' => 'required|integer',
            'published_at' => '',
            'cover_image' => 'nullable|url',
        ];

    public function setPost(Post $post)
    {
        $this->post = $post;
        $this->post_id = $this->post->id;
        $this->title = $this->post->title;
        $this->cover_image = $this->post->cover_image;
        $this->slug = $this->post->slug;
        $this->body = $this->post->body;
        $this->meta_description = $this->post->meta_description;
        $this->is_in_vault = $this->post->is_in_vault;
        $this->category_id = $this->post->category_id;
        $this->channel_id = $this->post->channel_id;
        $this->selectedCategory = $this->post->category_id;
        $this->selectedChannel = $this->post->channel_id;
        $this->author_id = $this->post->author_id;
        $this->published_at = $this->post->published_at;
    }

    public function store()
    {
        $this->slug = Str::slug($this->title);
        $data = $this->validate();
        Post::create($data);
    }

    public function update()
    {
        $this->slug = Str::slug($this->title);

        $data = $this->validate();

        $this->post->update($data);

        $this->setpost($this->post);
        //  $this->post->update($this->all());
    }
}
