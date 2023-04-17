<?php

use App\Http\Livewire\Posts\ShowChannelPosts;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

test('any user can view published posts by channel', function () {
  //  $this->withoutExceptionHandling();

    $user = User::factory()->create();
    $category = Category::factory()->create();
    $channel = Channel::factory()->create();

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


test('a signed in user can view published posts by channel', function () {

  $user = User::factory()->create();
  Category::factory()->create();
  $channel =Channel::factory()->create();

  $post = Post::factory()->create(['published_at' => now()->subMonth()]);
  
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

test('a signed in user can view unpublished future posts by channel', function () {

  $user = User::factory()->create();
  $category = Category::factory()->create();
  $channel = Channel::factory()->create();

  $post = Post::factory()->create(['published_at' => now()->addMonth()]);
  
  $this->signIn();

  Livewire::test(ShowChannelPosts::class, ['chan_slug' => $channel->slug])
  ->assertStatus(200)
  ->assertSee($post->title)
  ->assertSee('Draft')
  ->assertSee('by')
  ->assertSee($post->author->name)
  ->assertSee($post->body);
});

test('a signed in user can view unpublished posts by channel', function () {

  $user = User::factory()->create();
  Category::factory()->create();
  $channel = Channel::factory()->create();

  $post = Post::factory()->create(['published_at' => null]);

  $this->signIn();

  Livewire::test(ShowChannelPosts::class, ['chan_slug' => $channel->slug])
  ->assertStatus(200)
  ->assertSee($post->title)
  ->assertSee('Draft')
  ->assertSee('by')
  ->assertSee($post->author->name)
  ->assertSee($post->body);
});

test('displays "No Posts within this Channel" if colllection is empty', function () {
    //Set up
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $channel = Channel::factory()->create();

    // $post=Post::factory()->create(['published_at'=>now()]);

    //act and Assert
    Livewire::test(ShowChannelPosts::class, ['chan_slug' => $channel->slug])
    ->assertStatus(200)
    ->assertSee('Sorry, there are currently no Articles within this Channel');
});
