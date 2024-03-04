<?php

namespace App\Listeners;

use App\Events\PostPublished;
use App\Models\SiteUpdate;

class CreateSiteUpdate
{
    /**
     * Handle the event.
     */
    public function handle(PostPublished $event): void
    {
        // create a record in the site_update for when a post is updated
        $siteupdate = SiteUpdate::wherePostId($event->post->id)->get()->first();
        if (! $siteupdate) {
            $event->post->siteupdate()->create([
                'post_id' => $event->post->id,
                'user_id' => auth()->id(),
                'update_date' => $event->date->format('Y-m-d H:i:s'),
                'status' => 'Pending Notification',
            ]
            );

            return;
        }

        // $siteupdate->save(['update_date' => $event->date->format('Y-m-d H:i:s')]);
        // return;
    }
}
