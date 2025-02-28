<?php

declare(strict_types=1);

use App\Livewire\Channel\ManageChannels;
use Livewire\Livewire;

test('Channel Validation rules on save', function ($field, $value, $rule): void {
    Livewire::test(ManageChannels::class)
        ->set($field, $value)
        ->call('save')
        ->assertHasErrors([$field => $rule]);
})->with('channel_validation');
