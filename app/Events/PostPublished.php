<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class PostPublished
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
