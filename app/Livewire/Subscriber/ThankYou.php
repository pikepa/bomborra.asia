<?php

declare(strict_types=1);

namespace App\Livewire\Subscriber;

use Livewire\Component;

final class ThankYou extends Component
{
    public function render()
    {
        return view('livewire.subscriber.thank-you');
    }
}
