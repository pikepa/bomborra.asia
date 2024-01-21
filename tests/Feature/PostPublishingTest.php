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

test('that a published post displays a draft button ', function () {
    $this->signIn($this->user);

    $post = Post::factory()->create();

    Livewire::test(EditPost::class, ['origin' => 'P', 'slug' => $post->slug])
        ->assertOk()
        ->assertSee('Published :')
        ->assertSee($post->published_at->format('d-M-Y'))
        ->assertSee('Make Draft')
        ->assertSeeHtml('wire:click.prevent="unpublishPost()"')
        ->call('unpublishPost');

    $this->assertDatabaseHas('posts', ['published_at' => null]);
    $post->refresh();
    $this->assertEquals(null, $post->published_at);
});

test('that an upublished post displays a publish button ', function () {
    $this->signIn($this->user);
    $post = Post::factory()->create(['published_at' => null]);
    Livewire::test(EditPost::class, ['origin' => 'P', 'slug' => $post->slug])
        ->assertOk()
        ->assertSee('Published :')
        ->assertDontSee('Make Draft')
        ->assertSee('Publish')
        ->assertSeeHtml('wire:click.prevent="publishPost()"');
});

test('a post can be published', function () {
    Event::fake();
    // given we have an unpublished post
    $post = Post::factory()->create(['published_at' => Carbon::make(null)]);
    // when we publish with a given date
    $post->publish('24-01-19');
    // the post is updated and can be defined a s published
    $this->assertDatabaseHas('posts', ['published_at' => '2024-01-19']);
    // assert that the postpublished event is dispatched
    Event::assertDispatched(PostPublished::class);
});
test('a post can be un published', function () {
    // given we have an published post
    $post = Post::factory()->create(['published_at' => Carbon::now()]);
    // when we unpublish
    $post->unpublish();
    // the post is updated and can be defined as unpublished
    $this->assertDatabaseHas('posts', ['published_at' => null]);
});
