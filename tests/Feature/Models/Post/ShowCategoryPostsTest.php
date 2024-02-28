<?php

use App\Livewire\Posts\ShowCategoryPosts;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

test('any user can view published posts by category', function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create();
    $category = $category = Category::factory()->create();
    $channel = Channel::factory()->create();

    $post = Post::factory()->create([
        'published_at' => now()->subMonth(),
        'channel_id' => $channel->id,
        'category_id' => $category->id,
    ]);

    Livewire::test(ShowCategoryPosts::class, ['cat_slug' => $category->slug])
        ->assertStatus(200)
        ->assertSee($post->title)
        ->assertSee('Published on')
        ->assertSee($post->published_at->toFormattedDateString())
        ->assertSee('by')
        ->assertSee($post->author->name)
        ->assertSee($post->body);
});

test('a signed in user can view published posts by category', function () {
    $user = User::factory()->create();
    $category = $category = Category::factory()->create();
    $channel = Channel::factory()->create();

    $post = Post::factory()->create([
        'published_at' => now()->subMonth(),
        'channel_id' => $channel->id,
        'category_id' => $category->id,
    ]);
    $this->signIn();

    Livewire::test(ShowCategoryPosts::class, ['cat_slug' => $category->slug])
        ->assertStatus(200)
        ->assertSee($post->title)
        ->assertSee('Published on')
        ->assertSee($post->published_at->toFormattedDateString())
        ->assertSee('by')
        ->assertSee($post->author->name)
        ->assertSee($post->body);
});

test('a signed in user can view unpublished future posts by category', function () {
    $user = User::factory()->create();
    $category = $category = Category::factory()->create();
    $channel = Channel::factory()->create();

    $post = Post::factory()->create([
        'published_at' => now()->addMonth(),
        'channel_id' => $channel->id,
        'category_id' => $category->id,
    ]);

    $this->signIn();

    Livewire::test(ShowCategoryPosts::class, ['cat_slug' => $category->slug])
        ->assertStatus(200)
        ->assertSee($post->title)
        ->assertSee('Draft')
        ->assertSee('by')
        ->assertSee($post->author->name)
        ->assertSee($post->body);
});

test('a signed in user can view unpublished posts by category', function () {
    $user = User::factory()->create();
    $category = $category = Category::factory()->create();
    $channel = Channel::factory()->create();

    $post = Post::factory()->create([
        'published_at' => null,
        'channel_id' => $channel->id,
        'category_id' => $category->id,
    ]);

    $this->signIn();

    Livewire::test(ShowCategoryPosts::class, ['cat_slug' => $category->slug])
        ->assertStatus(200)
        ->assertSee($post->title)
        ->assertSee('Draft')
        ->assertSee('by')
        ->assertSee($post->author->name)
        ->assertSee($post->body);
});

test('displays "No Posts within this Category" if colllection is empty', function () {
    //Set up
    $user = User::factory()->create();
    $category = Category::factory()->create();
    Channel::factory()->create();

    // $post=Post::factory()->create(['published_at'=>now()]);

    //act and Assert
    Livewire::test(ShowCategoryPosts::class, ['cat_slug' => $category->slug])
        ->assertStatus(200)
        ->assertSee('Sorry, there are currently no Articles within this Category');
});
