<?php

use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\get;

it('can load the welcome page', function () {
    User::factory()->create();
    Channel::factory()->create();
    $category = Category::factory()->create(['slug' => 'welcome']);
    $post = Post::factory()->create([
        'category_id' => $category->id,
    ]);

    get('/')
        ->assertStatus(200)
        ->assertSee($post->title)
        ->assertSee('Enter');
});
