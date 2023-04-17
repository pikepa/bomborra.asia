<?php

use App\Models\Category;
use App\Models\Channel;
use App\Models\Link;
use App\Models\Post;
use App\Models\User;
use function Pest\Laravel\get;

it('can load the home page', function () {
    get('/home')
        ->assertStatus(200)
        ->assertSee('Bomborra Media Productions')
        ->assertSee('THE TRUTH ALWAYS BREAKS');
});

test('A guest can view a published post on the home page', function () {
    Category::factory()->create();
    Channel::factory()->create(['sort' => 1, 'status' => 1]);
    User::factory()->create();

    $post = Post::factory()->create(['published_at' => now()->subDay(), 'channel_id' => 1]);

    $this->get('/home')
    ->assertStatus(200)
    ->assertSee($post->title)
    ->assertSee('... more')
    ->assertSee(substr($post->description. 0, 50));
});

test('A guest can not view an unpublished post on the home page', function () {
    Category::factory()->create();
    Channel::factory()->create();
    User::factory()->create();

    $post = Post::factory()->create(['published_at' => null]);

    $response = $this->get('/home')
    ->assertStatus(200)
    ->assertDontSee($post->title);
});

test(' A guest can see an Active channel on the home page', function () {
    //Setup
    $channel = Channel::factory()->create(['status' => true]);

    $this->get('/home')
    ->assertSee($channel->name);
});
test(' A guest can see an Active link on the home page', function () {
    //Setup
    $this->signIn();
    $link = Link::factory()->create(['status' => true]);

    //Act and Assert
    $this->get('/home')
    ->assertSee($link->title);
});
