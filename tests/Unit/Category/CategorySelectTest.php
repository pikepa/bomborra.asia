<?php

use App\Http\Livewire\Forms\CategorySelect;
use Livewire\Livewire;

test('the select component emits an event on selection', function () {
    Livewire::test(CategorySelect::class)
        ->set('category_id', 1)
        ->assertDispatched('category_selected');
});
