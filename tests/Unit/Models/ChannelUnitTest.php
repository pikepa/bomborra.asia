<?php

use App\Livewire\Channel\ManageChannels;
use Livewire\Livewire;

test('Channel Validation rules on save', function ($field, $value, $rule) {
    Livewire::test(ManageChannels::class)
        ->set($field, $value)
        ->call('save')
        ->assertHasErrors([$field => $rule]);
})->with('channel_validation');
