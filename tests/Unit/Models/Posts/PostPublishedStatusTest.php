<?php

use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;

beforeEach(function () {
    Category::factory()->create();
    Channel::factory()->create();
    User::factory()->create();
});

test('a post with no published at date shows as draft', function () {
    $this->signIn();
    $post = Post::factory()->create(['published_at' => null]);

    expect($post->published_status)->toBe('Draft');
});

test('a post with a published date of today or less is published', function () {
    $this->signIn();
    $post = Post::factory()->create(['published_at' => now()->subMonth()]);

    expect($post->published_status)->toBe('Published');
});

test('a post with a future date is shown as draft', function () {
    $this->signIn();
    $post = Post::factory()->create(['published_at' => now()->addMonth()]);

    expect($post->published_status)->toBe('Draft');
});
