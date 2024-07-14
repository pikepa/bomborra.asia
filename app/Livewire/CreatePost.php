<?php

namespace App\Livewire;

use App\Livewire\Forms\PostForm;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreatePost extends Component
{
    public PostForm $form;

    // protected $listeners = [
    //     'body_value_updated',
    // ];

    public function category_selected($category_id)
    {
        $this->form->category_id = $category_id;
    }

    public function channel_selected($channel_id)
    {
        $this->form->channel_id = $channel_id;
    }

    public function body_value_updated($value)
    {
        $this->form->body = $value;
    }

    public function save()
    {
        $this->form->store();

        return redirect()->to('/posts/edit/'.$this->form->slug.'/P');

        session()->flash('message', 'Post Successfully added.');
        session()->flash('alertType', 'success');

    }

    public function mount()
    {
        $this->form->post = new Post;
        $this->form->author_id = Auth::id();

    }

    public function render()
    {
        return view('livewire.create-post');
    }
}
