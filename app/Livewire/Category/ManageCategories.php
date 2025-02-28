<?php

declare(strict_types=1);

namespace App\Livewire\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

final class ManageCategories extends Component
{
    public $name = '';

    public $slug = '';

    public $description;

    public $status = false;

    public $type = '';

    public $parent_id = null;

    public $category_id = '';

    public $categories;

    public $types = [];

    public $statuses = [];

    public $showTable = true;

    public $showEditForm = false;

    public $showAddForm = false;

    public $showAlert = false;

    protected $rules = [
        'name' => 'required|min:6|max:50',
        'slug' => 'required',
        'description' => 'required|min:10|max:240',
        'type' => 'required',
        'status' => 'required|boolean',
        'parent_id' => '',
    ];

    public function render()
    {
        $this->categories = Category::orderBy('name', 'asc')->get();

        $this->types = Category::TYPES;

        return view('livewire.category.manage-categories');
    }

    //  Switching Forms on Master Screen

    public function showAddForm()
    {
        $this->showTable = false;
        $this->showEditForm = false;
        $this->showAddForm = true;
    }

    public function showEditForm()
    {
        $this->showTable = false;
        $this->showEditForm = true;
        $this->showAddForm = false;
    }

    public function showTable()
    {
        $this->showTable = true;
        $this->showEditForm = false;
        $this->showAddForm = false;
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function create()
    {
        $this->showAddForm();
    }

    public function save()
    {
        $categoryData = $this->validate();

        Category::create($categoryData);

        $this->reset();
        $this->showTable();

        session()->flash('message', 'Category Successfully added.');
        session()->flash('alertType', 'success');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description;
        $this->status = $category->status;
        $this->type = $category->type;
        $this->parent_id = $category->parent_id;
        $this->category_id = $category->id;

        $this->showEditForm();
    }

    public function update($id)
    {
        $category = Category::find($id);
        $categoryData = $this->validate();

        $category->update($categoryData);

        $this->reset();
        $this->showTable();

        session()->flash('message', 'Category Successfully updated.');
        session()->flash('alertType', 'success');
    }

    public function delete($id)
    {
        $category = Category::find($id);

        $category->delete();

        $this->reset();
        $this->showTable();

        session()->flash('message', 'Category Successfully deleted.');
        session()->flash('alertType', 'success');
    }

    public function cancel()
    {
        $this->resetBanner();
        $this->showTable();
    }

    public function resetBanner()
    {
        $this->showAlert = false;

        session()->flash('message', '');
        session()->flash('alertType', '');
    }
}
