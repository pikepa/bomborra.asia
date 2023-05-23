<?php

use Livewire\Livewire;

test('an authorised user can pin an image to the post gallery', function () {

    Livewire::test(PinImages::class)
        ->set('x')
        ->call('setPinned');
})->toDo();
