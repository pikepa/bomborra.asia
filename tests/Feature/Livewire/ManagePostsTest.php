<?php

use App\Http\Livewire\Posts\EditPost;
use App\Http\Livewire\Posts\ManagePosts;
use App\Http\Livewire\Posts\ShowPost;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->category = Category::factory()->create();
    $this->channel = Channel::factory()->create();
});

test('An authorised user sees the Manage Posts page', function () {
    $this->signIn();
    Livewire::test(ManagePosts::class)->assertSee('Posts')
        ->assertSee('A list of all the posts in your account.');
});

test('A guest can view a published post', function () {
    User::factory()->create();

    $post = Post::factory()->create();

    Livewire::test(ShowPost::class, ['slug' => $post->slug])
        ->assertStatus(200)
        ->assertSee($post->category->name)
        ->assertSee(env('APP_NAME'))
        ->assertSee($post->title)
        ->assertSee($post->body);
});

test('An authorised user can see a list of all posts', function () {
    $this->signIn();

    $post1 = Post::factory()->create();
    $post2 = Post::factory()->create();

    Livewire::test(ManagePosts::class)
        ->set('showTable', true)
        ->call('render')
        ->assertSee($post1->title)
        ->assertSee($post1->channel->name)
        ->assertSee($post1->author_id)
        ->assertSee($post2->title)
        ->assertSee($post2->channel->name)
        ->assertSee($post2->author_id);
});

test('An authorised user can add a post', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(ManagePosts::class)
        ->call('create')
        ->assertSee('Title')
        ->set('cover_image', '')
        ->set('title', 'this is a post')
        ->set('slug', 'this-is-a-post')
        ->set('body', str_repeat('s', 100))
        ->set('is_in_vault', false)
        ->set('category_id', $this->category->id)
        ->set('channel_id', $this->channel->id)
        ->set('author_id', auth()->user()->id)
        ->set('published_at', '')
        ->set('meta_description', 'This is the meta description')
        ->call('save')
        ->assertSuccessful();

    $this->assertDatabaseCount('posts', 1)
        ->assertDatabaseHas('posts', ['title' => 'this is a post',
            'is_in_vault' => false,
            'notifiable' => true, ]);
});

test('When a user hits the add button the published date is not shown', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(ManagePosts::class)
        ->call('showAddForm')
        ->assertDontSee('Published');
});

test('When a user hits the edit button the published date is shown', function () {
    $this->actingAs(User::factory()->create());

    $post = Post::factory()->create();

    Livewire::test(EditPost::class, ['slug' => $post->slug, 'origin' => 'P'])
        ->assertSee('Published');
});

test('An authorised user can delete a post', function () {
    $this->actingAs(User::factory()->create());

    $post = Post::factory()->create();

    $this->assertDatabaseCount('posts', 1);

    Livewire::test(ManagePosts::class)
        ->call('delete', $post->id)
        ->assertSuccessful();

    $this->assertDatabaseCount('posts', 0);
});

test('A message is displayed when a user deletes a post', function () {
    $this->signIn();

    $post = Post::factory()->create();

    Livewire::test(ManagePosts::class)
        ->assertDontSee('Post Successfully deleted')
        ->call('delete', $post->id)
        ->assertSee('Post Successfully deleted');
});

test('An authorised User can mark a post as being in the vault', function () {
    $this->signIn();
    $post = Post::factory()->create(['is_in_vault' => false]);

    Livewire::test(EditPost::class, ['origin' => 'P', 'slug' => $post->slug])
        ->set('is_in_vault', true)
        ->set('meta_description', 'this is a new meta_description')
        ->call('update', $post->id);

    $this->assertDatabaseHas('posts', ['is_in_vault' => true,
        'meta_description' => 'this is a new meta_description', ]);
});

test('When a user hits the add button the create form is shown', function () {
    $this->signIn();

    Livewire::test(ManagePosts::class)
        ->call('showAddForm')
        ->assertSee('Add Post')
        ->assertSee('Save');
});

test('When a user hits the show table button the main table is shown', function () {
    $this->signIn();

    Livewire::test(ManagePosts::class)
        ->call('showTable')
        ->assertSee('Posts')
        ->assertDontSee('Edit Post')
        ->assertSee('Add Post');
});

test('An authorised user can filter posts by category in the dashboard', function () {
    $this->signIn();
    $category2 = Category::factory()->create();
    $post = Post::factory()->create(['category_id' => $this->category->id]);
    $post2 = Post::factory()->create(['category_id' => $category2->id]);

    Livewire::test(ManagePosts::class)
        ->call('showTable')
        ->set('categoryQuery', '')
        ->assertSee('Posts')
        ->set('showFilters', true)
        ->assertSee('Select Channel')
        ->assertSee('Select Category')
        ->assertSee($post->title)
        ->assertSee($post2->title)
        ->set('categoryQuery', $this->category->id)
        ->assertSee($post->title)
        ->assertDontSee($post2->title);
});

test('An authorised user can filter posts by channel in the dashboard', function () {
    $this->signIn();
    $channel2 = Channel::factory()->create();
    $post = Post::factory()->create(['channel_id' => $this->channel->id]);
    $post2 = Post::factory()->create(['channel_id' => $channel2->id]);

    Livewire::test(ManagePosts::class)
        ->call('showTable')
        ->set('channelQuery', '')
        ->assertSee('Posts')
        ->set('showFilters', true)
        ->assertSee('Select Channel')
        ->assertSee('Select Category')
        ->assertSee($post->title)
        ->assertSee($post2->title)
        ->set('channelQuery', $this->channel->id)
        ->assertSee($post->title)
        ->assertDontSee($post2->title);
});

test('The posts dashboard page has a clear button which clears filters', function () {
    $this->signIn();

    Livewire::test(ManagePosts::class)
        ->call('showTable')
        ->set('showFilters', true)
        ->assertSee('Clear')
        ->assertSee('Select Channel')
        ->assertSee('Select Category')
        ->set('channelQuery', $this->channel->id)
        ->set('categoryQuery', $this->channel->id)
        ->set('search', 'abc')
        ->assertSee($this->channel->name)
        ->call('clearFilter')
        ->assertSet('channelQuery', '')
        ->assertSet('categoryQuery', '')
        ->assertSet('search', '');
});
