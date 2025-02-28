<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Subscriber\RegisterSubscriber;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ManageSubscriberController
{
    /**
     * Show the form for creating a new subscriber.
     */
    public function create(): View
    {
        return view('livewire.subscriber.create-subscriber');
    }

    /**
     * Store a newly created subscriber in storage.
     */
    public function store(Request $request, RegisterSubscriber $registerSubscriber)
    {
        $subscriber = $registerSubscriber($request->all());

        return view('livewire.subscriber.thank-you');
    }
}
