<?php

use App\Events\PostIsPublished;
use App\Http\Livewire\Posts\EditPost;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;

beforeEach(function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $channel = Channel::factory()->create();
});

it('the publication of a post prompts a notification to subscribers', function () {
    Event::fake();
    $this->withoutExceptionHandling();
    $subscribers = Subscriber::factory()->count(5)->create(
        [
            'validated_at' => Carbon::now()->subMonth(),
        ]);

    $this->assertDatabaseCount('subscribers', 5);

    // Given that we have an unpublished post
    $post = Post::factory()->create(['published_at' => null, 'channel_id' => 1]);
    // When the post is published,
    Livewire::test(EditPost::class, ['origin' => 'P', 'slug' => $post->slug])
        ->call('publishPost')
        ->assertSuccessful();
    // a postIsPublished event is triggered.
    Event::assertDispatched(PostIsPublished::class);
    // then the event listener dispatches a notification to all the subscribers.

    $this->assertDatabaseCount('notifications', 5);
});
