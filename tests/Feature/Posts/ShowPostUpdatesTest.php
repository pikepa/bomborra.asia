<?php

use App\Livewire\Posts\ShowPostUpdates;
use App\Models\SiteUpdate;

beforeEach(function () {
    $this->signIn();
});

it('displays show-post-updates page', function () {
    $update = SiteUpdate::factory()->create();

    $this->get('/siteupdates')
        ->assertSeeLivewire(ShowPostUpdates::class)
        ->assertSee($update->title)
        ->assertStatus(200);
})->todo();
