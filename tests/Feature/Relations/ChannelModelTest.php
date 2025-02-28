<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;

it('has many posts', function (): void {
    // Set up
    $this->signIn();
    Category::factory()->create();

    $channel = Channel::factory()
        ->has(Post::factory()->count(2))
        ->create();

    expect($channel->posts)
        ->toHaveCount(2)
        ->each->toBeInstanceOf(Post::class);
});
