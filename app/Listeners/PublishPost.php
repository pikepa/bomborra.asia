<?php

namespace App\Listeners;

use App\Events\PublishPostRequested;
use App\Models\Post;
use Carbon\Carbon;

class PublishPost
{
    /**
     * Handle the event.
     */
    public function handle(PublishPostRequested $event): void
    {
        $post = Post::find($event->post->id)->update([
            'published_at' => Carbon::parse($event->date)->format('Y-m-d'),
        ]);
        //dd(Post::find($event->post->id));
    }
}
