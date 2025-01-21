<?php

use App\Mail\SubscribedEmail;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

use function Pest\Laravel\post;

test('an email is sent when a subscriber is created', function (): void {
    Mail::fake();

    $email = fake()->email;

    post('/subscribers', ['email' => $email, 'name' => 'Peter Piper']);

    Mail::AssertQueued(SubscribedEmail::class);
});

test('an email is not sent if subscriber is not created', function (): void {
    Mail::fake();

    $email = fake()->email;

    post('/subscribers', ['email' => 'asdaddaddasdadsa']);

    Mail::AssertNotSent(SubscribedEmail::class);
});

test('an OTP is stored in Cache for the subscriber', function (): void {
    Mail::fake();

    $email = fake()->email;

    post('/subscribers', ['email' => $email, 'name' => 'Peter Piper']);

    $subscriber = Subscriber::get()->first();

    $this->assertNotNull($subscriber->OTP());
});
