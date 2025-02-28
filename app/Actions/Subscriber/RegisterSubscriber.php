<?php

declare(strict_types=1);

namespace App\Actions\Subscriber;

use App\Data\SubscriberData;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Validator;

final class RegisterSubscriber
{
    public function __invoke(array $data): Subscriber
    {
        //  $data = new SubscriberData($data);
        $data = Validator::validate($data, [
            'email' => 'email|required|unique:subscribers',
            'name' => 'required|max:255',
        ]);

        $subscriber = Subscriber::create([
            ...$data,
        ]);

        $subscriber->sendOTP();

        return $subscriber;
    }
}
