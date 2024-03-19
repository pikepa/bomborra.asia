<?php

use App\Livewire\Pages\DashStandardPage;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('an authorised user can access the dashboard page', function () {
    $this->actingAs($this->user);

    $response = $this->get('/dashboard');
    $response->assertStatus(200);
});

test('a guest can not access the dashboard page', function () {
    $response = $this->get('/dashboard');
    $response->AssertRedirect('/login');
});

test('an authorised user can see the manage-categories page', function () {
    $this->actingAs($this->user);

    Livewire::test(DashStandardPage::class)
        ->set('show', 'categories')
        ->assertSeeLivewire('category.manage-categories');
});

test('an authorised user can see the manage-posts page', function () {
    $this->actingAs($this->user);

    Livewire::test(DashStandardPage::class)
        ->set('show', 'dash')
        ->set('show', 'posts')
        ->assertSeeLivewire('posts.index.table');
});

test('an authorised user can see the dashboaard page', function () {
    $this->actingAs($this->user);

    Livewire::test(DashStandardPage::class)
        ->set('show', 'dash')
        ->assertSee('Dashboard:-');
});

test('an authorised user can see the channels page', function () {
    $this->actingAs($this->user);

    Livewire::test(DashStandardPage::class)
        ->set('show', 'channels')
        ->assertSeeLivewire('channel.manage-channels');
});

test('an authorised user can see the home link', function () {
    $this->actingAs($this->user);

    Livewire::test(DashStandardPage::class)
        ->assertSee('Dashboard')
        ->assertSee('Home')
        ->assertSee('/')
        ->assertSee('Hi '.$this->user->name)
        ->assertSee('Log Out');
});
