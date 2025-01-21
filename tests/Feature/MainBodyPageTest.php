<?php

use App\Models\Category;
use App\Models\Channel;
use App\Models\Link;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

it('can load the home page', function (): void {
    $this->get('/home')
        ->assertStatus(200)
        ->assertSee('Bomborra Media Productions')
        ->assertSee('THE TRUTH ALWAYS BREAKS');
});

test('A guest can view a published post on the home page', function (): void {
    $category = Category::factory()->create();
    Channel::factory()->create(['sort' => 1, 'status' => 1]);
    User::factory()->create();

    $post = Post::factory()->create(['published_at' => now()->subDay(), 'channel_id' => 1]);

    $this->get('/home')
        ->assertStatus(200)
       // ->assertSee($post->title)
        ->assertSee($category->title)
        ->assertSee(substr($post->description. 0, 50));
});

test('A guest can not view an unpublished post on the home page', function (): void {
    Category::factory()->create();
    Channel::factory()->create();
    User::factory()->create();

    $post = Post::factory()->create(['published_at' => null]);

    $response = $this->get('/home')
        ->assertStatus(200)
        ->assertDontSee($post->title);
});

test(' A guest can see an Active channel on the home page', function (): void {
    // Setup
    $channel = Channel::factory()->create(['status' => true]);

    expect($this->get('/home'))->assertSee($channel->name);
});

test(' A guest can see an Active link on the home page', function (): void {
    // Setup
    $this->signIn();
    $link = Link::factory()->create(['status' => true]);
    Auth::logout();

    // Act and Assert
    expect($this->get('/home'))->assertSee($link->title);
});
test(' A guest can see a subscribe link on the home page', function (): void {

    // Act and Assert
    expect($this->get('/home'))->assertSee('Subscribe');
});
