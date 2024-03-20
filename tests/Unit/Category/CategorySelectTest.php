<?php

use App\Livewire\Forms\CategorySelect;
use App\Livewire\Posts\Index\Table;
use Livewire\Livewire;

test('the select category component emits an event on selection', function () {
    $this->signIn();
    Livewire::test(CategorySelect::class)
        ->set('category_id', 1)
        ->assertDispatched('category_selected', category_id: 1);

});
test('the table component reacts an event on selection', function () {
    $this->signIn();
    $check = Livewire::test(Table::class)
        ->assertSet('category_id', null)
        ->dispatch('category_selected', category_id: 1)
        ->assertSet('category_id', '1');
});
