<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\get;

it('can load the welcome page', function (): void {
    User::factory()->create();
    $post = Post::factory()->create([
        'slug' => 'studio-bomborra',
    ]);

    get('/')
        ->assertStatus(200)
        ->assertSee($post->title)
        ->assertSee('Enter');
});
