<?php

declare(strict_types=1);

use App\Livewire\Posts\Index\Table;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->category = Category::factory()->create();
    $this->channel = Channel::factory()->create();
});

test('An authorised User can search for a post in the dashboard', function (): void {
    $this->signIn();
    $post1 = Post::factory()->create();
    $post = Post::factory()->create(['title' => 'My Title']);

    Livewire::test(Table::class)
        ->set('search', 'title')
        ->assertSee($post->title)
        ->assertDontSee($post1->title);
});

test('An authorised User sees no Post found when too many chars in the search', function (): void {
    $this->signIn();
    $post1 = Post::factory()->create();
    $post = Post::factory()->create(['title' => 'My Title']);

    Livewire::test(Table::class)
        ->set('search', 'asdasdasdasdadasdadasdasdasdasdasdadadad')
        ->assertSee('No Posts found')
        ->assertDontSee($post->title)
        ->assertDontSee($post1->title);
});
