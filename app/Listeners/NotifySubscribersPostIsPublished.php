<?php

namespace App\Listeners;

use App\Events\PostIsPublished;
use App\Models\Subscriber;
use App\Notifications\PostWasPublished;

class NotifySubscribersPostIsPublished
{
    /**
     * Handle the event.
     */
    public function handle(PostIsPublished $event): void
    {
        $subscribers = Subscriber::where('validated_at', '<=', now());
        foreach ($subscribers as $subscriber) {
            $subscriber->notify(new PostWasPublished($event));
        }
    }
}
