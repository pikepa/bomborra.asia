<?php

use App\Models\Subscriber;

use function Pest\Laravel\post;

test('a subscriber can submit an OTP and be verified', function (): void {
    $subscriber = Subscriber::factory()->create();

    $OTP = $subscriber->cacheTheOTP();

    post('/verifyOTP/'.$subscriber->id.'/'.$subscriber->OTP())
        ->assertOk()
        ->assertSee('Thank you, your subscription has been verified.');

    post('/verifyOTP/'.$subscriber->id.'/'.$subscriber->OTP())
        ->assertOk()
        ->assertSee('Sorry validation can not be repeated or the validation code is incorrect.');

    $subscriber = Subscriber::get()->first();

    $this->assertNotNull($subscriber->validated_at);
});

test('a successful validation is shown to the user.', function (): void {
    $subscriber = Subscriber::factory()->create();

    $OTP = $subscriber->cacheTheOTP();

    post('/verifyOTP/'.$subscriber->id.'/'.$subscriber->OTP())
        ->assertOk()
        ->assertSee('Thank you, your subscription has been verified.');
});

test('an unsuccessful or duplicate validation is shown to the user.', function (): void {
    $subscriber = Subscriber::factory()->create();

    $OTP = $subscriber->cacheTheOTP();

    post('/verifyOTP/'.$subscriber->id.'/'.$subscriber->OTP())
        ->assertOk()
        ->assertSee('Thank you, your subscription has been verified.');

    post('/verifyOTP/'.$subscriber->id.'/'.$subscriber->OTP())
        ->assertOk()
        ->assertSee('Sorry validation can not be repeated or the validation code is incorrect.');
});
