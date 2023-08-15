<?php

use App\Http\Livewire\Emails\ShowUpdateEmails;
use App\Models\SiteUpdate;
use Livewire\Livewire;

test('an authorised user can see the ComposeEmail button on the dashboard', function () {
    $this->signIn();
    $this->get('/dashboard')->assertStatus(200)
        ->assertSee('Compose');
});

test('an authorised user can click on the compose button and see the site update listing', function () {
    $this->signIn();
    Livewire::test(ShowUpdateEmails::class)
        ->assertSee('Site Updates')
        ->assertSee('Add New')
        ->assertSee('Date')
        ->assertSee('Subject')
        ->assertSee('Status');
});

test('a User can see a table of SiteUpdates', function () {
    $this->signIn();

    $siteupdate1 = SiteUpdate::factory()->create();
    $siteupdate2 = SiteUpdate::factory()->create();

    Livewire::test(ShowUpdateEmails::class)
        ->assertSee($siteupdate1->subject)
        ->assertSee($siteupdate1->date->format('M d, Y'))
        ->assertSee($siteupdate2->subject);
});
