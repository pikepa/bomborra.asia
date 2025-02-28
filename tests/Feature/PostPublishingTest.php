<?php

declare(strict_types=1);

use App\Events\PostPublished;
use App\Livewire\Posts\EditPost;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;

use function Pest\Laravel\get;

beforeEach(function (): void {
    Category::factory()->create();
    Channel::factory()->create();
    $this->user = User::factory()->create();
});

test('that a post is created with null valued published_at', function (): void {
    $this->signIn($this->user);
    // given that we have created a new post
    $post = Post::factory()->create([
        'published_at' => null,
    ]);
    Livewire::test(EditPost::class, ['origin' => 'P', 'slug' => $post->slug])
        ->assertOk()
        ->assertSee('Published :')
        ->assertSee('Publish');
    // assert that the published_at date is null
    $this->assertDatabaseHas('posts', ['published_at' => null]);
});

test('that a published post displays a draft button ', function (): void {
    $this->signIn($this->user);

    $post = Post::factory()->create();
    $this->assertDatabaseHas('posts', ['published_at' => $post->published_at->format('Y-m-d')]);

    Livewire::test(EditPost::class, ['origin' => 'P', 'slug' => $post->slug])
  //  get('/posts/edit/'.$post->slug.'/P')
        ->assertOk()
        ->assertSee('Published :')
        ->assertSee($post->published_at->format('d-M-Y'))
        ->assertSee('Make Draft')
        ->call('unpublishPost');

    $this->assertDatabaseHas('posts', ['published_at' => null]);
    // $post->refresh();
    // dd($post);
    // $this->assertEquals(null, $post->published_at);
});

test('that an upublished post displays a publish button ', function (): void {
    $this->signIn($this->user);
    $post = Post::factory()->create(['published_at' => null]);
    Livewire::test(EditPost::class, ['origin' => 'P', 'slug' => $post->slug])
        ->assertOk()
        ->assertSee('Published :')
        ->assertDontSee('Make Draft')
        ->assertSee('Publish')
        ->assertSeeHtml('wire:click.prevent="publishPost()"');
});

test('a post can be published and Post published event fired', function (): void {
    Event::fake();
    // given we have an unpublished post
    $post = Post::factory()->create(['published_at' => Carbon::make(null)]);
    // when we publish without a given date
    Livewire::test(EditPost::class, ['origin' => 'P', 'slug' => $post->slug])
        ->assertOk()
        ->assertSee('Publish')
        ->set('form.temp_published_at', Carbon::now()->format('Y-m-d H:i:s'))
        ->assertSeeHtml('wire:click.prevent="publishPost()"')
        ->call('publishPost');
    // the post is updated and can be defined a s published
    $this->assertDatabaseHas('posts', ['published_at' => Carbon::now()->format('Y-m-d H:i:s')]);
    // assert that the postpublished event is dispatched
    Event::assertDispatched(PostPublished::class);
    $post->refresh();
    expect($post->published_status)->toBe('Published');
});

test('a post can be published in the future and has a site_update record', function (): void {
    $this->signIn($this->user);
    // given we have an unpublished post
    $post = Post::factory()->create(['published_at' => null]);
    // when we publishnwith a future date
    Livewire::test(EditPost::class, ['origin' => 'P', 'slug' => $post->slug])
        ->assertOk()
        ->assertSee('Publish')
        ->set('form.temp_published_at', Carbon::now()->addMonth()->format('Y-m-d H:i:s'))
        ->assertSeeHtml('wire:click.prevent="publishPost()"')
        ->call('publishPost');
    // the post is updated and can be defined as unpublished
    $this->assertDatabaseHas('posts', ['published_at' => Carbon::now()->addMonth()->format('Y-m-d H:i:s')]);
    $this->assertDatabaseHas('site_updates', ['post_id' => $post->id]);
    $post->refresh();
    expect($post->published_status)->toBe('Publication Pending');
});

test('a post can be unpublished', function (): void {
    $this->signIn($this->user);
    // given we have an published post
    $post = Post::factory()->create(['published_at' => Carbon::now()]);
    // when we unpublish
    Livewire::test(EditPost::class, ['origin' => 'P', 'slug' => $post->slug])
        ->assertOk()
        ->assertSee('Published :')
        ->assertSee($post->published_at->format('d-M-Y'))
        ->assertSee('Make Draft')
        ->assertSeeHtml('wire:click.prevent="unpublishPost()"')
        ->call('unpublishPost');
    // the post is updated and can be defined as unpublished
    $this->assertDatabaseHas('posts', ['published_at' => null]);
    $this->assertDatabaseCount('site_updates', 0);
    $post->refresh();
    expect($post->published_status)->toBe('Draft');
});
