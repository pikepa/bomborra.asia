<?php

use App\Http\Livewire\Emails\CreateUpdateEmail;

test('an authorised user can see the ComposeEmail button on the dashboard', function () {
    $this->signIn();
    $this->get('/dashboard')->assertStatus(200)
        ->assertSee('Compose');
});

test('an authorised user can see the SendEmailPage', function () {
    $this->signIn();
    $this->get('/email/composeandsendupdate')->assertStatus(200)
        ->assertSeeLivewire(CreateUpdateEmail::class)
        ->assertSee('Compose Update Email');
});

test('a guest can not the SendEmailPage', function () {
    $this->get('/email/composeandsendupdate')->assertRedirect('/login')
        ->assertDontSeeLivewire(CreateUpdateEmail::class);

});
