<?php

use App\Livewire\Posts\EditPost;
use App\Livewire\Posts\Index\Table;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->signIn($this->user);
});

test('Post Validation rules on save', function ($field, $value, $rule) {
    Livewire::test(Table::class)
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
