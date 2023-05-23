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

test('a non subscriber advised post shows notifiable true', function () {
    $this->signIn();

    $post = Post::factory()->create();

    expect($post->notifiable)->toBe(true);
});
