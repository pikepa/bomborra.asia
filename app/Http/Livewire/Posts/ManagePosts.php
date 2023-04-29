<?php

namespace App\Http\Livewire\Posts;

use App\Models\Post;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ManagePosts extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search;

    public $posts;

    public $post_id;

    public $title;

    public $slug;

    public $body;

    public $is_in_vault = false;

    public $category_id;

    public $channel_id;

    public $author_id;

    public $cover_image = 'https://d18sfhl837dknt.cloudfront.net/featured/J1aR7bQQON3gwr3GipXyXJ1gmA3FSwKiRfjCj8hr.jpg';

    public $meta_description;

    public $published_at = null;

    public $showAddForm = 0;

    public $showEditForm = 0;

    public $showTable = 1;

    public $channels;

    public $selectedChannel;

    public $categories;

    public $selectedCategory;

    public $post;

    public $showAlert = false;

    //  public $mediaItems = [];

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
        'published_at' => 'nullable',
        'cover_image' => 'nullable|url',
    ];

    // listen from event from CategorySelect

    protected $listeners = [
        'category_selected',
        'channel_selected',
        'make_featured',
    ];

    public function mount()
    {
        $this->author_id = auth()->user()->id;
    }

    public function render()
    {
        $this->posts = Post::search('title', $this->search)->with('author')->orderBy('published_at', 'desc')->get();

        return view('livewire.posts.manage-posts');
    }

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    public function updatedNewImage()
    {
        $this->validate(['newImage' => 'image|max:5000']);
    }

    public function showAddForm()
    {
        $this->showTable = false;
        $this->showEditForm = false;
        $this->showAddForm = true;
    }

    public function showTable()
    {
        $this->showTable = true;
        $this->showEditForm = false;
        $this->showAddForm = false;
    }

    public function category_selected($category_id)
    {
        $this->category_id = $category_id;
    }

    public function channel_selected($channel_id)
    {
        $this->channel_id = $channel_id;
    }

    public function create()
    {
        $this->showAddForm();
    }

    public function save()
    {
        $data = $this->validate();

        $post = Post::create($data);

        $this->resetExcept(['author_id']);

        //  return redirect()->to('/posts/edit'.$post->slug);

        session()->flash('message', 'Post Successfully added.');
        session()->flash('alertType', 'success');
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        $this->showAlert = true;

        session()->flash('message', ' Post Successfully deleted.');
        session()->flash('alertType', 'success');
    }

    public function cancel()
    {
        $this->resetBanner();
        $this->showTable();
    }

    public function resetBanner()
    {
        $this->showAlert = true;

        session()->flash('message', '');
        session()->flash('alertType', '');
    }
}
