<?php

use Illuminate\Support\Facades\Mail;
use function Pest\Laravel\post;

test('when a site update is triggered, emails are sent to validated subscribers', function () {
    Mail::fake();

    $email = fake()->email;

    post('/siteupdate', ['message' => 'this is the message', 'channel_id' => '1']);

    Mail::AssertQueued(SiteUpdateEmail::class);
});
