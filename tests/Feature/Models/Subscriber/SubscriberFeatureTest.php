<?php

use App\Livewire\Subscriber\ManageSubscribers;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;

test('a newsletter subscribe button appears on the welcome screen', function () {
    User::factory()->create();
    $category = Category::factory()->create(['slug' => 'welcome']);
    $channel = Channel::factory()->create(['slug' => 'no-channel']);

    $post = Post::factory()->create([
        'slug' => 'studio-bomborra',
    ]);
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
        ->assertSeeInOrder([$subsc1->name, $subsc2->name])
        ->assertSee('Search subscriber name')
        ->assertSee('Advanced Search')
        ->assertSee('Bulk Actions');
});

test('a subscriber can unsubscribe and remove themselves from the list', function () {
    $subscriber = Subscriber::factory()->create();

    $url = URL::signedRoute('unsubscribe', ['id' => $subscriber->id]);

    $this->post($url)->assertOk()
        ->assertViewIs('livewire.subscriber.sorry-youre-leaving');

    $this->assertDatabaseCount('subscribers', 0);
});

test('a signed in user can filter records via subscriber name', function () {
    $this->signIn();

    $subscr1 = Subscriber::factory()->create(['name' => 'Peter']);
    $subscr2 = Subscriber::factory()->create(['name' => 'Paul']);
    $subscr3 = Subscriber::factory()->create(['name' => 'Fred']);

    Livewire::test(ManageSubscribers::class)
        ->assertSeeInOrder([$subscr1->name, $subscr2->name, $subscr3->name])
        ->set('filters.search', 'pe')
        ->assertSee($subscr1->name)
        ->assertDontSee($subscr2->name)
        ->assertDontSee($subscr3->name);
});
test('an authorised user may select multiple subscribers and validate them', function () {
    $subscr2 = Subscriber::factory()->create();
    $subscr3 = Subscriber::factory()->create();

    Livewire::test(ManageSubscribers::class)
        ->set('selected', [$subscr2->id, $subscr3->id])
        ->assertSee($subscr2->name)
        ->assertSee($subscr3->name)
        ->assertSee('Bulk Actions')
        ->call('validateSelected')
        ->assertSee('Subscribers successfully validated.')
        ->assertSee($subscr2->validated_at)
        ->assertSee($subscr3->validated_at);
});
test('a User can select an multiple displayed rows and delete', function () {
    $this->signIn();

    $subscr1 = Subscriber::factory()->create();
    $subscr2 = Subscriber::factory()->create();
    $subscr3 = Subscriber::factory()->create();

    Livewire::test(ManageSubscribers::class)
        ->set('selected', [$subscr2->id, $subscr3->id])
        ->assertSee($subscr2->name)
        ->assertSee($subscr3->name)
        ->call('deleteSelected')
        ->assertSee('Subscribers successfully deleted.')
        ->assertSee($subscr1->name)
        ->assertDontSee($subscr2->name)
        ->assertDontSee($subscr3->name);
});

test('a signed in user can sort records by name', function () {
    $this->signIn();

    $subscr1 = Subscriber::factory()->create(['name' => 'Zack']);
    $subscr2 = Subscriber::factory()->create(['name' => 'Peter']);

    Livewire::test(ManageSubscribers::class)
        ->assertSeeInOrder([$subscr1->name, $subscr2->name])
        ->set('sortDirection', 'asc')
        ->set('sortField', 'name')
        ->assertSeeInOrder([$subscr2->name, $subscr1->name])
        ->set('sortDirection', 'desc')
        ->set('sortField', 'name')
        ->assertSeeInOrder([$subscr1->name, $subscr2->name]);
});

test('a signed in user can sort records by email', function () {
    $this->signIn();

    $subscr1 = Subscriber::factory()->create(['email' => 'peter@thepikes.net']);
    $subscr2 = Subscriber::factory()->create(['email' => 'sandy@thepikes.net']);

    Livewire::test(ManageSubscribers::class)
        ->assertSeeInOrder([$subscr1->name, $subscr2->email])
        ->set('sortDirection', 'asc')
        ->set('sortField', 'email')
        ->assertSeeInOrder([$subscr1->email, $subscr2->email])
        ->set('sortDirection', 'desc')
        ->set('sortField', 'email')
        ->assertSeeInOrder([$subscr2->email, $subscr1->email]);
});

test('a signed in user can sort records by validated_at', function () {
    $this->signIn();

    $subscr1 = Subscriber::factory()->create(['validated_at' => Carbon::now()]);
    $subscr2 = Subscriber::factory()->create(['validated_at' => Carbon::now()->subMonth(1)]);

    Livewire::test(ManageSubscribers::class)
        ->assertSeeInOrder([$subscr1->name, $subscr2->name])
        ->set('sortDirection', 'asc')
        ->set('sortField', 'validated_at')
        ->assertSeeInOrder([$subscr2->name, $subscr1->name])
        ->set('sortDirection', 'desc')
        ->set('sortField', 'validated_at')
        ->assertSeeInOrder([$subscr1->name, $subscr2->name]);
});

test('a signed in user can sort records by created_at', function () {
    $this->signIn();

    $subscr1 = Subscriber::factory()->create(['created_at' => Carbon::now()]);
    $subscr2 = Subscriber::factory()->create(['created_at' => Carbon::now()->subMonth(1)]);

    Livewire::test(ManageSubscribers::class)
        ->assertSeeInOrder([$subscr2->name, $subscr1->name])
        ->set('sortDirection', 'asc')
        ->set('sortField', 'created_at')
        ->assertSeeInOrder([$subscr2->name, $subscr1->name])
        ->set('sortDirection', 'desc')
        ->set('sortField', 'created_at')
        ->assertSeeInOrder([$subscr1->name, $subscr2->name]);
});
