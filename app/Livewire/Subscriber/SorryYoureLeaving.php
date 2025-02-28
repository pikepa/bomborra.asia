<?php

declare(strict_types=1);

namespace App\Livewire\Subscriber;

use Livewire\Component;

final class SorryYoureLeaving extends Component
{
    public function render()
    {
        return view('livewire.subscriber.sorry-youre-leaving');
    }
}
