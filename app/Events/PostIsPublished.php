<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostIsPublished
{
    use Dispatchable, SerializesModels;

    public $post;

    /**
     * Create a new event instance.
     */
    public function __construct($post)
    {
        $this->post = $post;
    }
}
