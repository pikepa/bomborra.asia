<?php

use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\SiteUpdate;
use App\Models\User;

beforeEach(function () {
    User::factory()->create();
    Category::factory()->create();
    Channel::factory()->create();
});

it('a post belongs to a channel', function () {
    $post = Post::factory()
        ->has(Channel::factory())
        ->create();

    expect($post->channel)
        ->toBeInstanceOf(Channel::class);
});

test('a post can have a SiteUpdate', function () {
    $post = Post::factory()
        ->has(Siteupdate::factory())
        ->create();
    expect($post->siteupdate)
        ->toBeInstanceOf(Siteupdate::class);
});
