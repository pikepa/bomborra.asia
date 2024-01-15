<?php

use App\Http\Livewire\Posts\EditPost;
use App\Http\Livewire\Posts\ManagePosts;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->signIn($this->user);
});

test('Post Validation rules on save', function ($field, $value, $rule) {
    Livewire::test(ManagePosts::class)
        ->set($field, $value)
        ->call('save')
        ->assertHasErrors([$field => $rule]);
})->with('post_validation');

test('when the post title is changed the slug changes', function () {
    Category::factory()->create();
    Channel::factory()->create();

    $post = Post::factory()->create([
        'title' => 'this-is-a-fake-title', ]);

    Livewire::test(EditPost::class, ['slug' => $post->slug, 'origin' => 'P'])
        ->set('title', 'this is a new title')
        ->call('update', $post->id);

    $this->assertDatabaseHas('posts', ['slug' => 'this-is-a-new-title']);
});

test('a post can be published now', function () {
    $post = Post::factory()->create(['published_at' => null]);
    $post->publish();
    $this->assertDatabaseHas('posts', ['published_at' => Carbon::now()->format('Y-m-d')]);
});

test('a post can be published with a specific date', function () {
    $date = Carbon::parse('13-01-2024')->format('Y-m-d');
    $post = Post::factory()->create(['published_at' => null]);
    $post->publish($date);
    $this->assertDatabaseHas('posts', ['published_at' => $date]);
});
test('a post can be unpublished ', function () {
    $post = Post::factory()->create();
    $post->unpublish();
    $this->assertDatabaseHas('posts', ['published_at' => null]);
});
