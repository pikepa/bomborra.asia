<?php

use App\Http\Livewire\Emails\ShowUpdateEmails;
use App\Models\SiteUpdate;
use Carbon\Carbon;
use Livewire\Livewire;

test('an authorised user can see the Notification button on the dashboard', function () {
    $this->signIn();
    $this->get('/dashboard')->assertStatus(200)
        ->assertSee('Notifications');
});
test('a guest can not see the Notification button on the dashboard', function () {
    $this->get('/dashboard')->assertStatus(302)
        ->assertRedirect('/login');
});

test('an authorised user can load the SiteUpdate page', function () {
    $this->signIn();
    $this->get('/siteupdates')->assertStatus(200)
        ->assertSeeLivewire(ShowUpdateEmails::class)
        ->assertSee('Notification Emails')
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

test('a User can select an individual displayed row and delete', function () {
    $this->signIn();

    $siteupdate1 = SiteUpdate::factory()->create();
    $siteupdate2 = SiteUpdate::factory()->create();
    $siteupdate3 = SiteUpdate::factory()->create();

    Livewire::test(ShowUpdateEmails::class)
        ->set('selected', [$siteupdate2->id, $siteupdate3->id])
        ->assertSee($siteupdate2->subject)
        ->assertSee($siteupdate3->subject)
        ->call('deleteSelected')
        ->assertSee($siteupdate1->subject)
        ->assertSee($siteupdate1->date->format('M d, Y'))
        ->assertDontSee($siteupdate2->subject)
        ->assertDontSee($siteupdate3->subject);
});
test('a User can select an multiple displayed rows and delete', function () {
    $this->signIn();

    $siteupdate1 = SiteUpdate::factory()->create();
    $siteupdate2 = SiteUpdate::factory()->create();
    $siteupdate3 = SiteUpdate::factory()->create();

    Livewire::test(ShowUpdateEmails::class)
        ->set('selected', [$siteupdate2->id, $siteupdate3->id])
        ->assertSee($siteupdate2->subject)
        ->assertSee($siteupdate3->subject)
        ->call('deleteSelected')
        ->assertSee('Notification Emails successfully deleted')
        ->assertSee($siteupdate1->subject)
        ->assertSee($siteupdate1->date->format('M d, Y'))
        ->assertDontSee($siteupdate2->subject)
        ->assertDontSee($siteupdate3->subject);
});

test('a signed in user can filter records via the search field', function () {
    $this->signIn();

    $siteupdate1 = SiteUpdate::factory()->create(['subject' => 'Peter']);
    $siteupdate2 = SiteUpdate::factory()->create(['subject' => 'Paul']);
    $siteupdate3 = SiteUpdate::factory()->create(['subject' => 'Fred']);

    Livewire::test(ShowUpdateEmails::class)
        ->assertSee($siteupdate1->subject)
        ->assertSee($siteupdate2->subject)
        ->assertSee($siteupdate3->subject)
        ->set('search', 'pe')
        ->assertSee($siteupdate1->subject)
        ->assertDontSee($siteupdate2->subject)
        ->assertDontSee($siteupdate3->subject);
});

test('a signed in user can sort records by subject', function () {
    $this->signIn();

    $siteupdate1 = SiteUpdate::factory()->create(['subject' => 'Zack']);
    $siteupdate2 = SiteUpdate::factory()->create(['subject' => 'Peter']);

    Livewire::test(ShowUpdateEmails::class)
        ->assertSeeInOrder([$siteupdate1->subject, $siteupdate2->subject])
        ->set('sortDirection', 'asc')
        ->set('sortField', 'subject')
        ->assertSeeInOrder([$siteupdate2->subject, $siteupdate1->subject])
        ->set('sortDirection', 'desc')
        ->set('sortField', 'subject')
        ->assertSeeInOrder([$siteupdate1->subject, $siteupdate2->subject]);
});

test('a signed in user can sort records by date', function () {
    $this->signIn();

    $siteupdate1 = SiteUpdate::factory()->create(['date' => Carbon::now()]);
    $siteupdate2 = SiteUpdate::factory()->create(['date' => Carbon::now()->subMonth(1)]);

    Livewire::test(ShowUpdateEmails::class)
        ->assertSeeInOrder([$siteupdate1->Subject, $siteupdate2->Subject])
        ->set('sortDirection', 'asc')
        ->set('sortField', 'date')
        ->assertSeeInOrder([$siteupdate2->Subject, $siteupdate1->Subject])
        ->set('sortDirection', 'desc')
        ->set('sortField', 'date')
        ->assertSeeInOrder([$siteupdate1->Subject, $siteupdate2->Subject]);
});

test('a signed in user can sort records by status', function () {
    $this->signIn();

    $siteupdate1 = SiteUpdate::factory()->create(['status' => 'draft']);
    $siteupdate2 = SiteUpdate::factory()->create(['status' => 'sent']);

    Livewire::test(ShowUpdateEmails::class)
        ->assertSeeInOrder([$siteupdate1->Subject, $siteupdate2->Subject])
        ->set('sortDirection', 'asc')
        ->set('sortField', 'status')
        ->assertSeeInOrder([$siteupdate2->Subject, $siteupdate1->Subject])
        ->set('sortDirection', 'desc')
        ->set('sortField', 'status')
        ->assertSeeInOrder([$siteupdate1->Subject, $siteupdate2->Subject]);
});

test('a signed in user can sort records by email', function () {
    $this->signIn();

    $siteupdate1 = SiteUpdate::factory()->create(['from' => 'peter@thepikes.net']);
    $siteupdate2 = SiteUpdate::factory()->create(['from' => 'sandy@thepikes.net']);

    Livewire::test(ShowUpdateEmails::class)
        ->assertSeeInOrder([$siteupdate1->Subject, $siteupdate2->Subject])
        ->set('sortDirection', 'asc')
        ->set('sortField', 'from')
        ->assertSeeInOrder([$siteupdate2->Subject, $siteupdate1->Subject])
        ->set('sortDirection', 'desc')
        ->set('sortField', 'from')
        ->assertSeeInOrder([$siteupdate1->Subject, $siteupdate2->Subject]);
});
