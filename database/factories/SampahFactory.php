<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;

use App\Models\Permintaan;
use App\Models\Transaksi;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sampah>
 */
class SampahFactory extends Factory
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
            'transaksi_id' => Transaksi::factory(),
            'kategori_sampah' => $this->faker->randomElement(['plastik', 'kertas', 'kaca']),
            'berat_sampah' => $this->faker->randomFloat(2, 0.1, 10),
            'poin' => $this->faker->numberBetween(1, 50),
        ];
    }
}
