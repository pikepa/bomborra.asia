<?php

use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Category\ManageCategories;


beforeEach(function () {
  $this->user = User::factory()->create();
}); 


test('A category name is required', function () {
  $this->signIn($this->user);

  Livewire::test(ManageCategories::class)
  ->set('name','')
  ->set('status', 1)
  ->call('save')
  ->assertHasErrors(['name' => 'required']);

});

test('A category has max chars 50', function () {
  $this->signIn($this->user);

  Livewire::test(ManageCategories::class)
  ->set('name',str_repeat('s',51))
  ->set('status', 1)
  ->call('save')
  ->assertHasErrors(['name' => 'max']);

});

test('A status is required', function () {
  $this->signIn($this->user);

  Livewire::test(ManageCategories::class)
  ->set('name','Foo bar')
  ->set('status', '')
  ->call('save')
  ->assertHasErrors(['status' => 'required']);

});

test('A status is an integer', function () {
  $this->signIn($this->user);

  Livewire::test(ManageCategories::class)
  ->set('name','Foo bar')
  ->set('status', '32.2')
  ->call('save')
  ->assertHasErrors(['status' => 'integer']);

});