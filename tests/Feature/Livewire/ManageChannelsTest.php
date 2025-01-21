<?php

use App\Livewire\Channel\ManageChannels;
use App\Models\Channel;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = User::factory()->create();
});

test('a guest cannot access the category index', function (): void {
    $this->get('/dashboard')
        ->assertRedirect('/login');
});

test('an authorised user can see a channel listing', function (): void {
    $this->signIn($this->user);
    $channel = Channel::factory()->create(['status' => true]);

    Livewire::test(ManageChannels::class)
        ->assertSee($channel->name)
        ->assertSee('Active');

    $this->assertDatabaseCount('channels', 1);
});

test('an authorised user can create a channel', function (): void {
    $this->signIn($this->user);

    Livewire::test(ManageChannels::class)
        ->call('create')
        ->assertSee('Add Channel')
        ->set('name', 'My Channel')
        ->set('status', true)
        ->set('sort', 1)
        ->call('save')
        ->assertSuccessful()
        ->assertSee('Channel Successfully added.');

    $this->assertDatabaseCount('channels', 1);

    expect(Channel::latest()->first()->slug)->toBe('my-channel');
});

test('an authorised user can update a channel', function (): void {
    $this->signIn($this->user);
    $channel = Channel::factory()->create();

    Livewire::test(ManageChannels::class)
        ->call('edit', $channel->id)
        ->set('name', 'My Channel')
        ->set('status', 1)
        ->call('update', $channel->id)
        ->assertSuccessful()
        ->assertSee('Channel Successfully updated.');

    expect(Channel::latest()->first()->name)->toBe('My Channel');
});

test('an authorised user can delete a channel', function (): void {
    $this->signIn($this->user);
    $channel = Channel::factory()->create();

    Livewire::test(ManageChannels::class)
        ->call('delete', $channel->id)
        ->assertSuccessful()
        ->assertSee('Channel Successfully deleted.');

    $this->assertDatabaseCount('channels', 0);
});
