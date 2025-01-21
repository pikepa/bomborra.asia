<?php

use App\Livewire\Links\ManageLinks;
use App\Models\Link;
use Livewire\Livewire;

it('has a links listing page', function (): void {
    $this->signin();
    $this->get(route('manage.links'))->assertStatus(200);
});

test('a guest gets redirected when trying to access links listing page', function (): void {
    $this->get(route('manage.links'))->assertRedirect('/login', 403);
});

test('a User can see a table of links', function (): void {
    $this->signin();

    $link1 = Link::factory()->create();
    $link2 = Link::factory()->create();

    Livewire::test(ManageLinks::class)
        ->assertSee($link1->title)
        ->assertSee($link2->title);
});

test('an authorised user can create a Link', function (): void {
    $this->signIn();
    $this->withoutExceptionHandling();

    Livewire::test(ManageLinks::class)
        ->call('create')
        ->assertSee('Add Link')
        ->set('title', 'My Link')
        ->set('url', 'https://google.com')
        ->set('position', 'right')
        ->set('status', true)
        ->set('sort', 1)
        ->call('save')
        ->assertSuccessful()
        ->assertSee('Link Successfully added.');

    $this->assertDatabaseCount('links', 1);

    expect(Link::latest()->first()->title)->toBe('My Link');
});

test('an authorised user can update a link', function (): void {
    $this->signIn();
    $link = Link::factory()->create();

    Livewire::test(ManageLinks::class)
        ->call('edit', $link->id)
        ->set('title', 'My Link has changed')
        ->set('position', 'Center')
        ->call('update', $link->id)
        ->assertSuccessful()
        ->assertSee('Link Successfully updated.');

    expect(Link::latest()->first()->title)->toBe('My Link has changed');
});

test('an authorised user can delete a link', function (): void {
    $this->signIn();
    $link = Link::factory()->create();

    Livewire::test(ManageLinks::class)
        ->call('delete', $link->id)
        ->assertSuccessful()
        ->assertSee('Link Successfully deleted.');

    $this->assertDatabaseCount('links', 0);
});

test('a signed in user can filter links via title', function (): void {
    $this->signIn();

    $link1 = Link::factory()->create(['title' => 'Peter']);
    $link2 = Link::factory()->create(['title' => 'Paul']);
    $link3 = Link::factory()->create(['title' => 'Fred']);

    Livewire::test(ManageLinks::class)
        ->assertSeeInOrder([$link1->name, $link2->name, $link3->name])
        ->set('filters.search', 'pe')
        ->assertSee($link1->name)
        ->assertDontSee($link2->name)
        ->assertDontSee($link3->name);
});
