<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;
use Livewire\Attributes\Title;

#[Title('Home')]
class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $channels = Channel::where('status', true)
            ->orderBy('sort', 'asc')->get();

        return view('home')->with(['channels' => $channels]);
    }
}
