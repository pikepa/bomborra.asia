<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnsubscribeController extends Controller
{
    
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        public $url;

        dd($request);
    }
}
