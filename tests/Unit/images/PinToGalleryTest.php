<?php

use Livewire\Livewire;

test('an authorised user can pin an image to the post gallery', function (): void {
    Livewire::test(PinImages::class)
        ->set('x')
        ->call('setPinned');
})->toDo();
