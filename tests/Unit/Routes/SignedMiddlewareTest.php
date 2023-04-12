<?php

use App\Models\Subscriber;
use Illuminate\Support\Facades\URL;

test('assert signed middleware is applied to the route', function(){

    $subscriber= Subscriber::factory()->create();

    $url = URL::signedRoute('unsubscribe', ['id' => $subscriber->id]);
   
    $this->post($url)->assertOk();

    $this->assertDatabaseCount('subscribers', 0);
});
    
   