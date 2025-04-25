<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'titre' => $this->faker->sentence(3),
        'duration' => $this->faker->numberBetween(90, 180),
        'rating' => $this->faker->randomFloat(1, 1, 9),
        'description' => $this->faker->paragraph,
        'release_date' => $this->faker->date,
        'director' => $this->faker->name,
        'actors' => implode(', ', $this->faker->words(3)),
        'poster' => $this->faker->imageUrl(),
        'background' => $this->faker->imageUrl(),
        'trailer' => $this->faker->url,
        'genre_id' => 1,
    ];
}
}
