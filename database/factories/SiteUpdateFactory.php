<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SiteUpdate>
 */
class SiteUpdateFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence;
        $slug = Str::slug($title, '-');

        return [
            'date' => Carbon::now(),
            'from' => $this->faker->unique()->safeEmail(),
            'subject' => $title,
            'slug' => $slug,
            'content' => $this->faker->paragraph(5),
            'status' => Arr::random(['Draft', 'Sent']),

        ];
    }
}
