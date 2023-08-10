<?php

use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\SiteUpdate;
use App\Models\User;

uses()->group('models');

beforeEach(function () {
    User::factory()->create();
    Category::factory()->create();
    Channel::factory()->create();
});

test('a Post relates to many SiteUpdates', function () {
    $this->withoutExceptionHandling();

    // set up
    $post = Post::factory()->create();
    $site_update = SiteUpdate::factory()->create();

    $this->assertCount(0, $post->fresh()->siteUpdates);

    $post->siteUpdates()->attach($post);

    $this->assertTrue($post->siteUpdates()->first()->is($site_update));
    $this->assertCount(1, $post->fresh()->siteUpdates);
});
