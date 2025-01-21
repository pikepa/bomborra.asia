<?php

use App\Models\Link;
use App\Models\User;

test('a link belongs to a user', function (): void {
    $user = $this->signIn();

    $link = Link::factory()
        ->create(['owner_id' => $user->id]);

    // $link = Link::factory()
    //  ->has(User::factory())
    //  ->create();

    expect($link->owner)
        ->toBeInstanceOf(User::class);
});
