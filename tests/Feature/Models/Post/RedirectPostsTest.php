<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;

beforeEach(function (): void {
    $this->category = Category::factory()->create();
    $this->channel = Channel::factory()->create();
});

test('a guest gets redirected when using an old url', function (): void {
    $this->signIn();
    $post = Post::factory()->create(['title' => 'Peter Pike']);

    $this->followingRedirects()->get('/$post->slug')
        ->assertSee('Peter Pike')
        ->assertSee('Back');
});
