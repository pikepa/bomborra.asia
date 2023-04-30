<?php

namespace App\Data;

use Carbon\CarbonImmutable;

class SubscriberData extends Data
{
    public function __construct(
      public string $name,    
      public string $email,
      public string $validation_key,
      public ?Date $validated_at,
    ) {

      private rules(
        
      )
    }
}
