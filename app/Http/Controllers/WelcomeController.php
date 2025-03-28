<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

final class WelcomeController
{
    public function __invoke(Request $request)
    {
        $post = Post::with('author')->whereSlug('studio-bomborra')->first();

        return view('welcome', compact('post'));
    }
}
