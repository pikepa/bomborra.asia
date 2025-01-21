<?php

use App\Models\Subscriber;
use Illuminate\Support\Facades\URL;

test('assert signed middleware is applied to the route', function (): void {
    $subscriber = Subscriber::factory()->create();
    $url = URL::signedRoute('unsubscribe', ['id' => $subscriber->id]);

    $this->post($url)->assertOk();
});
