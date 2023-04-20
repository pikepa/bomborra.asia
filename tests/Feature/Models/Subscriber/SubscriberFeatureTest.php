<?php

use App\Http\Livewire\Subscriber\ManageSubscribers;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;

test('a newsletter subscribe button appears on the welcome screen', function () {
    User::factory()->create();
    Category::factory()->create(['slug' => 'welcome']);
    Channel::factory()->create(['slug' => 'no-channel']);
    Channel::factory()->create(['slug' => 'no-channel']);
    $post = Post::factory()->create();

    $this->get('/')->assertSuccessful()
       ->assertSee($post->title)
       ->assertSee('Enter')
       ->assertSee('Subscribe ');
});

test('a guest user can see the create subscriber page', function () {
    $this->get('/subscribers/create')
         ->assertSuccessful()
         ->assertSee('Updates Registration')
         ->assertSee('Full Name')
         ->assertSee('Email Address')
         ->assertSee('Submit');
});
test('the create subscriber page contains the livewire menu components', function () {
    $this->get('/subscribers/create')
         ->assertSeeLivewire('menus.menu-bottom')
         ->assertSeeLivewire('menus.menu-top');
});

test('an authorised user can see a list of subscribers', function () {
    $this->signin();

    $subsc1 = Subscriber::factory()->create();
    $subsc2 = Subscriber::factory()->create();

    Livewire::test(ManageSubscribers::class)
        ->set('showTable', true)
        ->call('render')
        ->assertSee($subsc1->name)
        ->assertSee($subsc1->email)
        ->assertSee($subsc2->name)
        ->assertSee($subsc2->email);
});

test('a subscriber can unsubscribe and remove themselves from the list', function () {
    $subscriber = Subscriber::factory()->create();

    $url = URL::signedRoute('unsubscribe', ['id' => $subscriber->id]);

    $this->post($url)->assertOk()
            ->assertViewIs('livewire.subscriber.sorry-youre-leaving');

    $this->assertDatabaseCount('subscribers', 0);
});
