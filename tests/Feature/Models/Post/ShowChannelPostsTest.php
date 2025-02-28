<?php

declare(strict_types=1);

use App\Livewire\Posts\ShowChannelPosts;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

test('any user can view published posts by channel', function (): void {
    //  $this->withoutExceptionHandling();

    $category = $category = Category::factory()->create();
    $channel = Channel::factory()->create();

    $post = Post::factory()->create([
        'published_at' => now()->subMonth(),
        'channel_id' => $channel->id,
        'category_id' => $category->id,
    ]);

    $post = Post::factory()->create(['published_at' => now()->subMonth(), 'channel_id' => $channel->id]);

    Livewire::test(ShowChannelPosts::class, ['chan_slug' => $channel->slug])
        ->assertStatus(200)
        ->assertSee($post->title)
        ->assertSee('Published on')
        ->assertSee($post->published_at->toFormattedDateString())
        ->assertSee('by')
        ->assertSee($post->author->name)
        ->assertSee($post->body);
});

test('a signed in user can view published posts by channel', function (): void {
    $user = User::factory()->create();
    $category = $category = Category::factory()->create();
    $channel = Channel::factory()->create();

    $post = Post::factory()->create([
        'published_at' => now()->subMonth(),
        'channel_id' => $channel->id,
        'category_id' => $category->id,
    ]);

    $this->signIn();

    Livewire::test(ShowChannelPosts::class, ['chan_slug' => $channel->slug])
        ->assertStatus(200)
        ->assertSee($post->title)
        ->assertSee('Published on')
        ->assertSee($post->published_at->toFormattedDateString())
        ->assertSee('by')
        ->assertSee($post->author->name)
        ->assertSee($post->body);
});

test('a signed in user can view unpublished future posts by channel', function (): void {
    $user = User::factory()->create();
    $category = $category = Category::factory()->create();
    $channel = Channel::factory()->create();

    $post = Post::factory()->create([
        'published_at' => now()->addMonth(),
        'channel_id' => $channel->id,
        'category_id' => $category->id,
    ]);

    $this->signIn();

    Livewire::test(ShowChannelPosts::class, ['chan_slug' => $channel->slug])
        ->assertStatus(200)
        ->assertSee($post->title)
        ->assertSee('Draft')
        ->assertSee('by')
        ->assertSee($post->author->name)
        ->assertSee($post->body);
});

test('a signed in user can view unpublished posts by channel', function (): void {
    $user = User::factory()->create();
    $category = $category = Category::factory()->create();
    $channel = Channel::factory()->create();

    $post = Post::factory()->create([
        'published_at' => null,
        'channel_id' => $channel->id,
        'category_id' => $category->id,
    ]);

    $this->signIn();

    Livewire::test(ShowChannelPosts::class, ['chan_slug' => $channel->slug])
        ->assertStatus(200)
        ->assertSee($post->title)
        ->assertSee('Draft')
        ->assertSee('by')
        ->assertSee($post->author->name)
        ->assertSee($post->body);
});

test('displays "No Posts within this Channel" if colllection is empty', function (): void {
    // Set up
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $channel = Channel::factory()->create();

    // $post=Post::factory()->create(['published_at'=>now()]);
    // act and Assert
    Livewire::test(ShowChannelPosts::class, ['chan_slug' => $channel->slug])
        ->assertStatus(200)
        ->assertSee('Sorry, there are currently no Articles within this Channel');
});
