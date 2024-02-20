<?php

use App\Livewire\Posts\ShowPostUpdates;
use App\Models\Post;
use App\Models\SiteUpdate;
use Carbon\Carbon;
use Livewire\Livewire;

test('an authorised user can see the Notification link on the dashboard', function () {
    $this->signIn();
    $this->get('/dashboard')->assertStatus(200)
        ->assertSee('Notifications');
});
test('a guest can not see the Notification link on the dashboard', function () {
    $this->get('/dashboard')->assertStatus(302)
        ->assertRedirect('/login');
});

test('an authorised user can load the SiteUpdate page', function () {
    $this->signIn();
    $this->get('/siteupdates')->assertStatus(200)
        ->assertSeeLivewire(ShowPostUpdates::class)
        ->assertSee('Post Published Notifications')
       // ->assertSee('Add New')
        ->assertSee('Date')
        ->assertSee('Post Title')
        ->assertSee('Post Owner')
        ->assertSee('Status');
});

test('a User can see a table of SiteUpdates', function () {
    $this->signIn();
    $siteupdate1 = SiteUpdate::factory()->create(['user_id' => auth()->id()]);
    $siteupdate2 = SiteUpdate::factory()->create(['user_id' => auth()->id()]);

    Livewire::test(ShowPostUpdates::class)
        ->assertSee($siteupdate1->owner->name)
        ->assertSee($siteupdate1->date_for_humans)
        ->assertSee($siteupdate2->owner->name);
});

test('a User can select an individual displayed row and delete', function () {
    $this->signIn();

    $siteupdate1 = SiteUpdate::factory()->create();
    $siteupdate2 = SiteUpdate::factory()->create();
    $siteupdate3 = SiteUpdate::factory()->create();

    Livewire::test(ShowPostUpdates::class)
        ->set('selected', [$siteupdate2->id, $siteupdate3->id])
        ->assertSee($siteupdate2->subject)
        ->assertSee($siteupdate3->subject)
        ->call('deleteSelected')
        ->assertSee($siteupdate1->subject)
        ->assertSee($siteupdate1->update_date->format('M d, Y'))
        ->assertDontSee($siteupdate2->subject)
        ->assertDontSee($siteupdate3->subject);
});

test('a User can select multiple displayed rows and delete', function () {
    $this->signIn();

    $siteupdate1 = SiteUpdate::factory()->create();
    $siteupdate2 = SiteUpdate::factory()->create();
    $siteupdate3 = SiteUpdate::factory()->create();

    Livewire::test(ShowPostUpdates::class)
        ->set('selected', [$siteupdate2->id, $siteupdate3->id])
        ->assertSee($siteupdate2->subject)
        ->assertSee($siteupdate3->subject)
        ->call('deleteSelected')
        ->assertSee('Notification successfully deleted')
        ->assertSee($siteupdate1->subject)
        ->assertSee($siteupdate1->update_date->format('M d, Y'))
        ->assertDontSee($siteupdate2->subject)
        ->assertDontSee($siteupdate3->subject);
});

test('a signed in user can filter records via the search field', function () {
    $this->signIn();
    $post1 = Post::factory()->create(['title' => 'Peter']);
    $post2 = Post::factory()->create(['title' => 'Paul']);
    $post3 = Post::factory()->create(['title' => 'Fred']);

    $siteupdate1 = SiteUpdate::factory()->create(['post_id' => $post1->id]);
    $siteupdate2 = SiteUpdate::factory()->create(['post_id' => $post2->id]);
    $siteupdate3 = SiteUpdate::factory()->create(['post_id' => $post3->id]);

    Livewire::test(ShowPostUpdates::class)
        ->assertSee($siteupdate1->post->title)
        ->assertSee($siteupdate2->post->title)
        ->assertSee($siteupdate3->post->title)
        ->set('search', 'pe')
        ->assertSee($siteupdate1->post->title)
        ->assertDontSee($siteupdate2->post->title)
        ->assertDontSee($siteupdate3->post->title);
});

// test('a signed in user can sort records by subject', function () {
//     $this->signIn();

//     $siteupdate1 = SiteUpdate::factory()->create(['subject' => 'Zack']);
//     $siteupdate2 = SiteUpdate::factory()->create(['subject' => 'Peter']);

//     Livewire::test(ShowUpdateEmails::class)
//         ->assertSeeInOrder([$siteupdate1->subject, $siteupdate2->subject])
//         ->set('sortDirection', 'asc')
//         ->set('sortField', 'subject')
//         ->assertSeeInOrder([$siteupdate2->subject, $siteupdate1->subject])
//         ->set('sortDirection', 'desc')
//         ->set('sortField', 'subject')
//         ->assertSeeInOrder([$siteupdate1->subject, $siteupdate2->subject]);
// });

test('a signed in user can sort records by date', function () {
    $this->signIn();

    $siteupdate1 = SiteUpdate::factory()->create(['update_date' => Carbon::now()]);
    $siteupdate2 = SiteUpdate::factory()->create(['update_date' => Carbon::now()->subMonth(1)]);

    Livewire::test(ShowPostUpdates::class)
        ->assertSeeInOrder([$siteupdate1->post->title, $siteupdate2->post->title])
        ->set('sortDirection', 'asc')
        ->set('sortField', 'update_date')
        ->assertSeeInOrder([$siteupdate2->post->title, $siteupdate1->post->title])
        ->set('sortDirection', 'desc')
        ->set('sortField', 'update_date')
        ->assertSeeInOrder([$siteupdate1->post->title, $siteupdate2->post->title]);
});

test('a signed in user can sort records by status', function () {
    $this->signIn();

    $siteupdate1 = SiteUpdate::factory()->create(['status' => 'draft']);
    $siteupdate2 = SiteUpdate::factory()->create(['status' => 'sent']);

    Livewire::test(ShowPostUpdates::class)
        ->assertSeeInOrder([$siteupdate1->Subject, $siteupdate2->Subject])
        ->set('sortDirection', 'asc')
        ->set('sortField', 'status')
        ->assertSeeInOrder([$siteupdate2->Subject, $siteupdate1->Subject])
        ->set('sortDirection', 'desc')
        ->set('sortField', 'status')
        ->assertSeeInOrder([$siteupdate1->Subject, $siteupdate2->Subject]);
});
