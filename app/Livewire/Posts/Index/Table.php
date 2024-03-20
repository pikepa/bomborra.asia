<?php

namespace App\Livewire\Posts\Index;

use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

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

    public $channelQuery = '';    // dropdown selected channel result

    public $categoryQuery = '';   // dropdown selected category result

    public $statusQuery = '';     // dropdown selected status result
    //  public $search is in the searchable trait.

    public $channels;

    public $selectedChannel; // form selected channel

    public $queryChannels = [];   // all channels for select dropdown

    public $queryStatuses = ['Draft', 'Publication Pending',  'Published'];

    public $categories;

    public $selectedCategory;

    public $queryCategories;

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

    public function mount()
    {
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

    public function create()
    {
        $this->showAddForm();
    }

    public function save()
    {
        $data = $this->validate();

        $post = Post::create($data);

        $this->resetExcept(['author_id']);

        return redirect()->to('/posts/edit/'.$post->slug.'/O');

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

    protected function applyChannelFilter($query)
    {
        return $this->channelQuery === ''
            ? $query
            : $query
                ->where('channel_id', $this->channelQuery);
    }

    protected function applyCategoryFilter($query)
    {
        return $this->categoryQuery === ''
            ? $query
            : $query
                ->where('category_id', $this->categoryQuery);
    }
    // protected function applyStatusFilter($query)
    // {
    //     switch ($this->statusQuery) {
    //         case 'Draft':
    //           $temp = '';
    //           break;
    //         case 'Published':
    //           $temp = '"<=" , now()';
    //           break;
    //         case 'Pending Publication':
    //           $temp = '> now()';
    //           break;
    //         default:

    //       }

    //     return $this->statusQuery === ''
    //         ? $query
    //         : $query
    //             ->where('published_at', $temp);
    // }

    public function render()
    {
        $query = Post::query()->orderBy('published_at', 'desc');
        $this->applySearch($query); // (Defined within the Searchable Trait)
        $this->applyChannelFilter($query);
        $this->applyCategoryFilter($query);
        // $this->applyStatusFilter($query);

        return view('livewire.posts.index.table', [
            'posts' => $query->paginate(10),
        ]);
    }

    //     ->when($this->statusQuery != '', function ($query) {
    //         $query->where('published_at', $this->statusQuery);
    //     })
}
