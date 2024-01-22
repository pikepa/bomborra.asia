<?php

namespace App\Listeners;

use App\Events\PostPublished;
use App\Models\Subscriber;

class NotifySubscribers
{
    /**
     * Handle the event.
     */
    public function handle(PostPublished $event): void
    {
        // for each validated subscriber create an email notification
        $subscribers = Subscriber::where('validated_at', '!=', null)->get();

        // foreach ($subscribers as $subscriber) {
        //  dd($subscriber);
        //}
    }
}
