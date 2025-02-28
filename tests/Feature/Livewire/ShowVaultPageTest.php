<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;

beforeEach(function (): void {
    $this->user = User::factory()->create();
});

test('the vault displays posts marked as in the vault', function (): void {
    Category::factory()->create();
    Channel::factory()->create();

    $post = Post::factory()->create(['author_id' => $this->user->id,
        'is_in_vault' => true, ]);

    $this->get('/vault/')->assertStatus(200)
        ->assertSee($post->title)
        ->assertSee('The Vault')
        ->assertSee('Back');
});
