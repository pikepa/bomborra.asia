<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $post = Post::with('author')->whereSlug('studio-bomborra')->first();

        return view('welcome', compact('post'));
    }
}
