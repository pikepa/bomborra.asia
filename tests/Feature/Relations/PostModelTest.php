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

test('a post belongs to a SiteUpdate', function () {

    $this->withoutExceptionHandling();

    // set up
    $post = Post::factory()->create();
    $site_update = SiteUpdate::factory()->create();

    $this->assertCount(0, $site_update->fresh()->posts);

    $site_update->posts()->attach($post);

    $this->assertTrue($site_update->posts->first()->is($post));
    $this->assertCount(1, $site_update->fresh()->posts);
});
