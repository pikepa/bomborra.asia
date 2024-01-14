<?php

use App\Http\Livewire\Posts\EditPost;
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
    //Setup
    $this->signIn($this->user);
    $post = Post::factory()->create();
    //Act and Assert
    get('/posts/edit/'.$post->slug.'/P')
        ->assertSuccessful()
        ->assertSee($post->title)
        ->assertSee('Submit');
});

test('an authorised user can edit a post page', function () {
    //Setup
    $this->signIn($this->user);
    $post = Post::factory()->create();

    //Act and Assert
    Livewire::test(EditPost::class, ['origin' => 'P', 'slug' => $post->slug])
        ->set('title', 'This title needs to be over ten characters')
        ->call('update', $post->id)
        ->assertSuccessful();

    expect(Post::find($post->id)->title)->toBe('This title needs to be over ten characters');
});
