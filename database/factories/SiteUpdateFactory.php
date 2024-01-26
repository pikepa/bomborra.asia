<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SiteUpdate>
 */
class SiteUpdateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'update_date' => Carbon::now()->format('Y-m-d'),
            'post_id' => Post::factory()->create(),
            'user_id' => User::factory()->create(),
            'status' => Arr::random(['Draft', 'Sent']),

        ];
    }
}
