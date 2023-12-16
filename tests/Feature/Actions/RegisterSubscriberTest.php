<?php

use App\Actions\Subscriber\RegisterSubscriber;
use App\Models\Subscriber;

use function Pest\Laravel\post;

test('anyone can subscribe to the Newsletter', function () {
    $action = app(RegisterSubscriber::class);

    $subscriber = $action([
        'email' => 'foo@foobar.com',
        'name' => 'Peter Piper',
    ]);

    expect($subscriber->refresh())
        ->email->toBe('foo@foobar.com')
        ->name->toBe('Peter Piper');
});

test('an new email must be unique on the subscribers table', function () {
    $email = fake()->email;

    Subscriber::create(['email' => $email]);

    post('/subscribers', ['email' => $email])

        ->assertInvalid(['email' => 'The email has already been taken.']);
});

test('an new email must be a valid email', function () {
    $email = fake()->name;

    post('/subscribers', ['email' => $email])

        ->assertInvalid(['email' => 'The email must be a valid email address.']);
});

test('an email is required for a subscriber', function () {
    post('/subscribers', ['email' => ''])

        ->assertInvalid(['email' => 'The email field is required.']);
});

test('a name must be less than 255chars', function () {
    post('/subscribers', ['name' => str_repeat('*', 256)])

        ->assertInvalid(['name' => 'The name must not be greater than 255 characters.']);
});
