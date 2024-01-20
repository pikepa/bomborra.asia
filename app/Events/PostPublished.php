<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostPublished
{
    use Dispatchable, SerializesModels;

    public $post;

    public $date;

    /**
     * Create a new event instance.
     */
    public function __construct($post, $date)
    {
        $this->post = $post;
        $this->date = $date;
    }
}
