<?php

namespace App\Livewire\Images;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class Upload extends Component
{
    use WithFileUploads;

    public $photo;

    public $post;

    public function mount($post)
    {
        $this->post = $post;
    }

    public function render()
    {
        return view('livewire.images.upload');
    }

    public function save()
    {
        $this->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
        ]);

        $post = Post::find($this->post->id);
        $post->addMedia($this->photo->getRealPath())
            ->usingName($this->photo->getClientOriginalName())
            ->toMediaCollection('photos', 's3');

        $this->photo = '';

        return redirect()->route('edit.post', ['slug' => $this->post->slug, 'origin' => 'P']);
    }

    public function deleteImage($image_id, $post_id)
    {
        $post = Post::findOrFail($post_id);
        $post->deleteMedia($image_id);

        return redirect()->route('edit.post', ['slug' => $this->post->slug, 'origin' => 'P']);
    }

    public function changeFeatured($image_url, $post_id)
    {
        $post = Post::findOrFail($post_id);
        $post->cover_image = $image_url;
        $post->update();

        return redirect()->route('edit.post', ['slug' => $this->post->slug, 'origin' => 'P']);
    }
}
