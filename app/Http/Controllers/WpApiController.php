<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\WpApi;
use Illuminate\Http\Request;

final class WpApiController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $var = new WpApi;
        //  $posts = $var->importImages();
        $count = Post::count();
    }
}
