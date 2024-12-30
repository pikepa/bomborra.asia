<?php

use App\Livewire\Posts\EditPost;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\get;

beforeEach(function () {
    Category::factory()->create();
    Channel::factory()->create();
    $this->user = User::factory()->create();
});

test('an authorised user can see the edit a post page', function () {
    // Setup
    $this->signIn($this->user);
    $post = Post::factory()->create();
    // Act and Assert
    get('/posts/edit/'.$post->slug.'/P')
        ->assertSuccessful()
        ->assertSee($post->title)
        ->assertSee('Submit');
});

test('an authorised user can edit a post page', function () {
    // Setup
    $this->signIn($this->user);
    $post = Post::factory()->create();

    // Act and Assert
    Livewire::test(EditPost::class, ['origin' => 'D', 'slug' => $post->slug])
        ->set('form.title', 'This title needs to be over ten characters')
        ->set('form.body', 'This body needs to be over ten characters')
        ->set('form.meta_description', 'This meta_description needs to be over ten characters')
        ->call('update', $post->id)
        ->assertSuccessful();

    $newPost = Post::find($post->id);
    expect($newPost->title)->toBe('This title needs to be over ten characters');
    expect($newPost->body)->toBe('This body needs to be over ten characters');
    expect($newPost->meta_description)->toBe('This meta_description needs to be over ten characters');

    $this->assertDatabaseHas('posts', [
        'title' => 'This title needs to be over ten characters',
        'body' => 'This body needs to be over ten characters',
        'meta_description' => 'This meta_description needs to be over ten characters',
        'is_in_vault' => 0,
    ]);
});
