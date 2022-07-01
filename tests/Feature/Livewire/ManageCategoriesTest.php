<?php

use App\Models\User;
use Livewire\Livewire;
use App\Models\Category;
use App\Http\Livewire\Pages\DashStandardPage;
use App\Http\Livewire\Category\ManageCategories;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('a guest cannot access the category index', function () {
    $this->get('/dashboard')
            ->assertRedirect('/login');
});



test('an authorised user can create a category', function () {
    $this->signIn($this->user);

    Livewire::test(ManageCategories::class)
    ->call('create')
    ->assertSee('Add Category')
    ->assertSee('Category')
    ->set('name', 'FOOBAR')
   // ->set('slug', 'foobar')
    ->set('type', 'main')
    ->set('parent_id', '')
    ->set('status', true)
    ->call('save')
    ->assertSuccessful();
    
     $this->assertDatabaseCount('categories', 1);


     expect(Category::latest()->first()->slug)->toBe('foobar');
});

test('an authorised user can update a category', function () {
    $this->signIn($this->user);
    $category = Category::factory()->create();

    Livewire::test(ManageCategories::class)
    ->call('edit', $category->id)
    ->set('name', 'FOOBAR')
    ->set('status', 1)
    ->call('update',$category->id)
    ->assertSuccessful();

    expect(Category::latest()->first()->name)->toBe('FOOBAR');
});

test('an authorised user can delete a category', function () {
    $this->signIn($this->user);
    $category = Category::factory()->create();

    Livewire::test(ManageCategories::class)
    ->call('delete', $category->id)
    ->assertSuccessful();

    $this->assertDatabaseCount('categories', 0);
});

test('an authorised user can see a category listing', function () {
    $this->signIn($this->user);
    $category = Category::factory()->create();

    Livewire::test(ManageCategories::class)
    ->assertSee($category->category);

    $this->assertDatabaseCount('categories', 1);
});
