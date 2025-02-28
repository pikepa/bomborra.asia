<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
final class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->sentence;
        $slug = Str::slug($name, '-');

        return [
            'name' => $name,
            'slug' => $slug,
            'description' => $this->faker->sentence,
            'type' => 'main',
            'status' => $this->faker->numberBetween(0, 1),
        ];
    }
}
