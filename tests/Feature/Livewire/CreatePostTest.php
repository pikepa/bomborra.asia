<?php

use App\Livewire\CreatePost;
use App\Models\Category;
use App\Models\Channel;
use Illuminate\Support\Str;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(CreatePost::class)
        ->assertStatus(200)
        ->assertSee('Add Post')
        ->assertSee('Title')
        ->assertSee('Body')
        ->assertSee('Meta Description');
});

it('creates a post successfully', function () {
    $category = Category::factory()->create();
    $channel = Channel::factory()->create();
    $this->signIn();

    $title = 'The New Title';
    Livewire::test(CreatePost::class)
        ->set('form.title', $title)
        ->set('form.body', 'Body Text is too short')
        ->set('form.slug', Str::slug($title))
        ->set('form.meta_description', 'this is the meta description')
        ->set('form.is_in_vault', false)
        ->set('form.category_id', $category->id)
        ->set('form.channel_id', $channel->id)
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect('/posts/edit/'.Str::slug($title).'/P');

    $this->assertDatabaseHas('posts', ['title' => 'The New Title']);
    //  ->assertRedirect('/posts');
});

test('When a user hits the add button the published date is not shown', function () {
    $this->signIn();
    Livewire::test(CreatePost::class)
        ->assertDontSee('Published');
});
