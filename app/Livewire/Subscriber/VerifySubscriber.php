<?php

namespace App\Livewire\Subscriber;

use App\Models\Subscriber;
use Livewire\Component;

class VerifySubscriber extends Component
{
    public $subscriber_id;

    public $otp;

    public $subscriber;

    public $isVerified = false;

    public function mount($id, $otp)
    {
        $this->subscriber_id = $id;
        $this->otp = $otp;

        $subscriber = Subscriber::find($this->subscriber_id);

        if ($this->otp === $subscriber->validation_key) {
            $subscriber->update(['validated_at' => now(), 'validation_key' => '']);
            $this->isVerified = true;
            // return response(null,201);
        } else {
            $this->isVerified = false;
        }
    }

    public function render()
    {
        return view('livewire.subscriber.verify-subscriber');
    }
}
