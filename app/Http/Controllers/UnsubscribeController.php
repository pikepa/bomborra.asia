<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

final class UnsubscribeController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $subscriber = Subscriber::findOrFail($request->id);
        $subscriber->delete();

        // Send confirmation email

        return view('livewire.subscriber.sorry-youre-leaving');
    }
}
