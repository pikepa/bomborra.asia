<?php

use App\Http\Livewire\Posts\EditPost;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Livewire;

beforeEach(function () {
    Category::factory()->create();
    Channel::factory()->create();
    $this->user = User::factory()->create();
});

test('that a post is created with null valued published_at', function () {
    $this->signIn($this->user);
    //given that we have created a new post
    $post = Post::factory()->create([
        'published_at' => '',
    ]);
    Livewire::test(EditPost::class, ['origin' => 'P', 'slug' => $post->slug])
        ->assertOk()
        ->assertSee('Published :')
        ->assertSee('Publish');
    //assert that the published_at date is null
});
test('that a published post displays a draft button which when clicked sets the published at to null', function () {
    $this->signIn($this->user);
    $post = Post::factory()->create();
    Livewire::test(EditPost::class, ['origin' => 'P', 'slug' => $post->slug])
        ->assertOk()
        ->assertSee('Published :')
        ->assertSee($post->published_at->format('d-M-Y'))
        ->assertSee('Make Draft')
        ->call('unpublishPost')->assertOk();

    $newPost = Post::first();
    $this->assertEquals(null, $newPost->published_at);
});
test('that a upublished post displays a publish button which when clicked sets the published at to the current date', function () {
    $this->signIn($this->user);
    $post = Post::factory()->create(['published_at' => null]);
    Livewire::test(EditPost::class, ['origin' => 'P', 'slug' => $post->slug])
        ->assertOk()
        ->assertSee('Published :')
        ->assertDontSee('Make Draft')
        ->assertSee('Publish')
        ->call('publishPost')->assertOk();
    $post->refresh();
    //dd($post);
    $this->assertEquals(Carbon::now()->format('Y-m-d'), $post->published_at->format('Y-m-d'));
});
test('that a an authorised user can set a published date', function () {
    $this->signIn($this->user);
    $post = Post::factory()->create(['published_at' => null]);
    Livewire::test(EditPost::class, ['origin' => 'P', 'slug' => $post->slug])
        ->assertOk()
        ->assertSee('Published :')
        ->assertDontSee('Make Draft')
        ->assertSee('Publish')
        ->set('temp_published_at', '01-03-2024')
        ->call('publishPost')->assertOk();
    $post->refresh();
    //dd($post);
    $this->assertEquals(Carbon::parse('01-03-2024')->format('Y-m-d'), $post->published_at->format('Y-m-d'));
});
