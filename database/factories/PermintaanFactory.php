<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;

use App\Models\Mesin;
use App\Models\Permintaan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permintaan>
 */
class PermintaanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $id = Str::uuid();
        do {
            $otp = $this->faker->numerify(str_repeat('#', 5));
        } while (
            Permintaan::where('mesin_id', $id)
            ->where('kode_verifikasi', $otp)
            ->exists() || $otp[0] === '0'
        );

        return [
            'id' => $id,
            'mesin_id' => Mesin::factory(),
            'kode_verifikasi' => $otp,
        ];
    }
}
