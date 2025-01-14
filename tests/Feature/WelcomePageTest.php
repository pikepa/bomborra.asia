<?php

use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\get;

it('can load the welcome page', function () {
    User::factory()->create();
    $post = Post::factory()->create([
        'slug' => 'studio-bomborra',
    ]);

    get('/')
        ->assertStatus(200)
        ->assertSee($post->title)
        ->assertSee('Enter');
});
