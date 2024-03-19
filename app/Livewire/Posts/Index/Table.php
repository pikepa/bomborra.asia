<?php

namespace App\Livewire\Posts\Index;

use App\Models\Post;
use App\Models\Channel;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Cache;

class Table extends Component
{
    use Searchable, WithFileUploads, WithPagination;

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

    public $notifiable = true;

    public $published_at = null;

    public $showAddForm = 0;

    public $showEditForm = 0;

    public $showTable = 1;

    public $channels;

    public $selectedChannel; // form selected channel

    public $channelQuery = '';    // dropdown selected channel

    public $queryChannels = [];   // all channels for select dropdown

    public $statusQuery = '';

    public $queryStatuses = ['Draft', 'Publication Pending',  'Published'];
    public $categories;

    public $selectedCategory;

    public $categoryQuery = '';

    public $queryCategories = [];

    public $post;

    public $showAlert = false;

    public $showFilters = false;

    //  public $mediaItems = [];

    protected $rules =
    [
        'title' => 'required|min:10|max:250',
        'slug' => 'required',
        'body' => 'required|min:20',
        'is_in_vault' => 'required|boolean',
        'cover_image' => 'nullable|url',
        'meta_description' => 'required|min:20|max:500',
        'published_at' => 'nullable',
        'channel_id' => 'required|integer',
        'author_id' => 'required|integer',
        'category_id' => 'required|integer',
    ];

    // listen from event from CategorySelect

    protected $listeners = [
        'category_selected',
        'channel_selected',
        'status_selected',
        // 'make_featured',
    ];

    public function mount()
    {
        $this->queryCategories = Cache::rememberForever('queryCategories', function () {
            return Category::orderBy('name', 'asc')->get();
        });
        $this->queryChannels = Cache::rememberForever('quertChannels', function () {
            return Channel::orderBy('name', 'asc')->get();
        });
        $this->author_id = auth()->user()->id;
    }

    public function paginationView()
    {
        return 'pagination';
    }

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    public function updatedNewImage()
    {
        $this->validate(['newImage' => 'image|max:5000']);
    }

    public function clearFilter()
    {
        $this->categoryQuery = '';
        $this->channelQuery = '';
        $this->statusQuery = '';
        $this->search = '';
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

    #[On('category_selected')]
    public function updateSelected($category_id)
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

        return redirect()->to('/posts/edit'.$post->slug);

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

    public function resetPage()
    {
        return $this->setPage(1);
    }

    public function resetBanner()
    {
        $this->showAlert = true;

        session()->flash('message', '');
        session()->flash('alertType', '');
    }

    public function render()
    {
        $query = Post::query()->orderBy('published_at', 'desc');
        $this->applySearch($query); // (Defined within the Searchable Trait)

        return view('livewire.posts.index.table', [
            'posts' => $query->paginate(10),
        ]);
    }

    //     ->when($this->statusQuery != '', function ($query) {
    //         $query->where('published_at', $this->statusQuery);
    //     })
    //     ->when($this->categoryQuery != '', function ($query) {
    //         $query->where('category_id', $this->categoryQuery);
    //     })
    //     ->when($this->channelQuery != '', function ($query) {
    //         $query->where('channel_id', $this->channelQuery);
    //     })
    //     ->with('author', 'channel', 'category')->orderBy('published_at', 'desc')->get();

}
