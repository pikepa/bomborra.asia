<?php

declare(strict_types=1);

use App\Livewire\Posts\DisplayPostGallery;
use App\Livewire\Posts\ShowPost;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    Category::factory()->create();
    Channel::factory()->create();
    User::factory()->create();
});

test('A guest can view a published post', function (): void {
    $post = Post::factory()->create(['published_at' => now()->subMonth()]);

    Livewire::test(ShowPost::class, [$post->slug])
        ->assertStatus(200)
        ->assertSee($post->title)
        ->assertSee('Published on')
        ->assertSee($post->published_at->toFormattedDateString())
        ->assertSee('by')
        ->assertSee($post->author->name)
        ->assertSee($post->body)
        ->assertSeeLivewire(DisplayPostGallery::class);
});

test('A guest can not view an unpublished post', function (): void {
    $post = Post::factory()->create(['published_at' => null]);

    Livewire::test(ShowPost::class, [$post->slug])
        ->assertRedirect('/login');
});

test('An Auth User can view an unpublished post', function (): void {
    $post = Post::factory()->create(['published_at' => null]);
    $this->signIn();

    Livewire::test(ShowPost::class, [$post->slug])
        ->assertStatus(200)
        ->assertSee($post->title)
        ->assertSee('Draft')
        ->assertSee('by')
        ->assertSee($post->author->name)
        ->assertSee($post->body);
});

test('An Auth User can view a future published post', function (): void {
    $post = Post::factory()->create(['published_at' => now()->addMonth()]);
    $this->signIn();

    Livewire::test(ShowPost::class, [$post->slug])
        ->assertStatus(200)
        ->assertSee($post->title)
        ->assertSee('Publication Pending')
        ->assertSee('by')
        ->assertSee($post->author->name)
        ->assertSee($post->body);
});

test('An Auth User can view a published post', function (): void {
    $post = Post::factory()->create(['published_at' => now()]);
    $this->signIn();

    Livewire::test(ShowPost::class, [$post->slug])
        ->assertStatus(200)
        ->assertSee($post->title)
        ->assertSee('Published on')
        ->assertSee($post->published_at->toFormattedDateString())
        ->assertSee('by')
        ->assertSee($post->author->name)
        ->assertSee($post->body)
        ->assertSeeLivewire(DisplayPostGallery::class);
});
