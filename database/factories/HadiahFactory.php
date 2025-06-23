<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hadiah>
 */
class HadiahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'nama_hadiah' => fake()->sentence(),
            'poin' => fake()->numberBetween(10, 100),
            'rating' => fake()->randomFloat(2, 0, 5),
            'jumlah_penukaran' => fake()->numberBetween(0, 100),
            'link_foto' => null,
        ];
    }
}
