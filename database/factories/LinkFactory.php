<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Links>
 */
final class LinkFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'url' => $this->faker->url,
            'owner_id' => User::inRandomOrder()->first(),
            'position' => mb_strtoupper('right'),
            'sort' => '1',
            'status' => true,
        ];
    }
}
