<?php

use App\Livewire\Forms\ChannelSelect;
use Livewire\Livewire;

test('the select component emits an event on selection', function () {
    Livewire::test(ChannelSelect::class)
        ->set('channel_id', 1)
        ->assertDispatched('channel_selected');
});
