<?php

use App\Livewire\Emails\CreateUpdateEmail;
use App\Livewire\Posts\ShowPostUpdates;
use App\Models\SiteUpdate;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;

beforeEach(function () {
    $this->signIn();
});

test('a guest is redirected to login', function () {
    Auth::logout();
    $this->get('/email/compose_update/1-2')
        ->assertStatus(302)
        ->assertRedirect('/login');
});

test('a signed in user can see the update email for selected notifications', function () {
    $updates = SiteUpdate::factory()->count(2)->create();
    $this->get('/email/compose_update/1-2')
        ->assertSeeLivewire(CreateUpdateEmail::class)
        ->assertStatus(200)
        ->assertSee('Compose Update Email')
        ->assertSee('From')
        ->assertSee('Subject')
      // ->assertSee('Cancel')
      // ->assertSee('Submit')
        ->assertSee($updates[0]->title)
        ->assertSee($updates[1]->title);
});
test('a logged in user can cancel and return to the notifications tab', function () {
    $updates = SiteUpdate::factory()->count(2)->create();
    Livewire::test(CreateUpdateEmail::class, ['selected' => '1-2'])
        ->assertOK()
        ->call('goBack')
        ->assertSeeLivewire(ShowPostUpdates::class);

})->skip();
