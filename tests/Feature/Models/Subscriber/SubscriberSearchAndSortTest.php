<?php

use App\Http\Livewire\Subscriber\ManageSubscribers;
use App\Models\Subscriber;
use Livewire\Livewire;

test('An authorised User can search for a subscriber in the dashboard', function () {
    $this->signIn();
    $subsc1 = Subscriber::factory()->create();
    $subsc = Subscriber::factory()->create(['name' => 'my name']);

    Livewire::test(ManageSubscribers::class)
        ->set('search', 'name')
        ->assertSee($subsc->name)
        ->assertDontSee($subsc1->name);
});

test('an authorised user can select unvalidated subscribers', function () {
    $this->signIn();
    $subsc1 = Subscriber::factory()->create(['validated_at' => now()->subMonth()]);
    $subsc2 = Subscriber::factory()->create(['validated_at' => null]);

    Livewire::test(ManageSubscribers::class)
        ->assertSee($subsc1->name)
        ->assertSee($subsc2->name)
        ->set('isNotValidated', true)
        ->assertDontSee($subsc1->name)
        ->assertSee($subsc2->name);
});

test('An authorised User sees no Subscriber found when too many chars in the search', function () {
    $this->signIn();
    $subsc1 = Subscriber::factory()->create();
    $subsc = Subscriber::factory()->create(['name' => 'my name']);

    Livewire::test(ManageSubscribers::class)
        ->set('search', 'asdasdasdasdadasdadasdasdasdasdasdadadad')
        ->assertSee('No Subscribers found')
        ->assertDontSee($subsc->title)
        ->assertDontSee($subsc1->title);
});
