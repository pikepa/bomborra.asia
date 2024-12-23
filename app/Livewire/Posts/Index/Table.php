<?php

namespace App\Livewire\Posts\Index;

use App\Livewire\Forms\PostForm;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Title('Manage Posts')]
class Table extends Component
{
    public PostForm $form;

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

    public function mount()
    {
        $this->author_id = auth()->user()->id;
    }

    public function paginationView()
    {
        return 'pagination';
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

    public function showTable()
    {
        $this->showTable = true;
        $this->showEditForm = false;
        $this->showAddForm = false;
    }

    public function create()
    {
        return redirect()->to(route('create.post'));
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
}
