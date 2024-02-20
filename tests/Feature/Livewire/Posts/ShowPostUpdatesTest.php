<?php

namespace Tests\Feature\Livewire\Posts;

use App\Livewire\Posts\ShowPostUpdates;
use Livewire\Livewire;
use Tests\TestCase;

class ShowPostUpdatesTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(ShowPostUpdates::class);

        $component->assertStatus(200);
    }
}
