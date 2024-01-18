<?php

use App\Events\PostPublished;
use App\Http\Livewire\Posts\EditPost;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
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
        'published_at' => null,
    ]);
    Livewire::test(EditPost::class, ['origin' => 'P', 'slug' => $post->slug])
        ->assertOk()
        ->assertSee('Published :')
        ->assertSee('Publish');
    //assert that the published_at date is null
    $this->assertDatabaseHas('posts', ['published_at' => null]);
});

test('that a published post displays a draft button which when clicked sets the published at to null', function () {
    $this->signIn($this->user);
    $post = Post::factory()->create();

    Livewire::test(EditPost::class, ['origin' => 'P', 'slug' => $post->slug])
        ->assertOk()
        ->assertSee('Published :')
        ->assertSee($post->published_at->format('d-M-Y'))
        ->assertSee('Make Draft')
        ->set('published_at', '')
        ->call('update', $post->id);

    $this->assertDatabaseHas('posts', ['published_at' => null]);
    $post->refresh();
    $this->assertEquals(null, $post->published_at);
});

test('that an upublished post displays a publish button which when clicked sets the published at to the current date', function () {
    $this->signIn($this->user);
    $post = Post::factory()->create(['published_at' => null]);
    Livewire::test(EditPost::class, ['origin' => 'P', 'slug' => $post->slug])
        ->assertOk()
        ->assertSee('Published :')
        ->assertDontSee('Make Draft')
        ->assertSee('Publish')
        ->set('published_at', Carbon::now())
        ->call('update', $post->id);

    $this->assertDatabaseHas('posts', ['published_at' => Carbon::now()]);
});

test('an PostPublished event is generated after a post is published', function () {
    Event::fake();
    $post = Post::factory()->create(['published_at' => null]);
    // dd($post);
    Livewire::test(EditPost::class, ['origin' => 'P', 'slug' => $post->slug])
        ->assertOk()
        ->call('publishPost');

    Event::assertDispatched(PostPublished::class);
});
