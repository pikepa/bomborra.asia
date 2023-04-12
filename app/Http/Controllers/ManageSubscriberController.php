<?php

namespace App\Http\Controllers;

use App\Actions\Subscriber\RegisterSubscriber;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class ManageSubscriberController extends Controller
{
    /**
     * Show the form for creating a new subscriber.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('livewire.subscriber.create-subscriber');
    }

    /**
     * Store a newly created subscriber in storage.
     */
    public function store(Request $request, RegisterSubscriber $registerSubscriber)
    {
        $subscriber = $registerSubscriber($request->all());

        return redirect('subscribers/thankyou');
    }

    /**
     * Display the specified thank you screen.
     */
    public function show()
    {
        return view('livewire.subscriber.thank-you');
    }
}
