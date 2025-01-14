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
    $body = 'Some string to test the body';
    // Act and Assert
    Livewire::test(EditPost::class, ['origin' => 'D', 'slug' => $post->slug])
        ->assertSee($post->body)
        ->set('form.title', 'This title needs to be over ten characters')
        ->set('form.body', $body)
        ->set('form.meta_description', 'This meta_description needs to be over ten characters')
        ->call('update', $post->id)
        ->assertSet('form.body', $body)
        ->assertSuccessful();

    $this->assertDatabaseHas('posts', [
        'title' => 'This title needs to be over ten characters',
        'slug' => 'this-title-needs-to-be-over-ten-characters',
        'body' => $body,
        'meta_description' => 'This meta_description needs to be over ten characters',
        'is_in_vault' => 0,
    ]);
});
