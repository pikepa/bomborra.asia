<?php

declare(strict_types=1);

use App\Livewire\Forms\ChannelSelect;
use App\Models\Channel;
use Livewire\Livewire;

test('when an active channel is created it appears on the sorted select list correctly', function (): void {
    $channelA = Channel::factory()->create(['name' => 'bbbbbbbb', 'status' => 1,
        'sort' => 2, ]);
    $channelB = Channel::factory()->create(['name' => 'aaaaaaaa', 'status' => 1,
        'sort' => 1, ]);
    Livewire::test(ChannelSelect::class)
        ->assertOk()
        ->assertSee($channelA->name)
        ->assertViewHas('queryChannels')
        ->assertSeeInOrder([$channelB->name, $channelA->name]);
});
test('when a channel is created as inactive it does not appear on the select list', function (): void {
    $channel = Channel::factory()->create(['status' => 0]);

    Livewire::test(ChannelSelect::class)
        ->assertOk()
        ->assertViewHas('queryChannels')
        ->assertDontSee($channel->name);
});
