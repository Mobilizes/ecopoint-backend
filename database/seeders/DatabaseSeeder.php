<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Hadiah;
use App\Models\Mesin;
use App\Models\Penukaran;
use App\Models\Permintaan;
use App\Models\Sampah;
use App\Models\Transaksi;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    private function seed_test()
    {
        $test_user = User::factory()->create([
            'nama_depan' => 'Test',
            'nama_belakang' => 'User',
            'email' => 'test@example.com',
        ]);

        $test_hadiahs = Hadiah::factory(10)->create([
            'nama_hadiah' => 'Test Hadiah',
        ]);

        foreach ($test_hadiahs as $test_hadiah) {
            $test_penukaran = Penukaran::factory(5)->create([
                'user_id' => $test_user->id,
                'hadiah_id' => $test_hadiah->id,
            ]);
        }

        $test_mesins = Mesin::factory(3)->create([
            'nama_mesin' => 'Test Mesin',
        ]);

        foreach ($test_mesins as $test_mesin) {
            $test_permintaan = Permintaan::factory(5)->create([
                'mesin_id' => $test_mesin->id,
            ]);

            $test_transaksis = Transaksi::factory(10)->create([
                'mesin_id' => $test_mesin->id,
                'user_id' => $test_user->id,
            ]);

            foreach ($test_transaksis as $transaksi) {
                $test_sampah = Sampah::factory(2)->create([
                    'transaksi_id' => $transaksi->id,
                    'kategori_sampah' => 'kaca',
                    'berat_sampah' => 100.0,
                    'poin' => 10,
                ]);
            }
        }
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seed_test();

        $mesins = Mesin::factory()->count(5)->create();

        $users = User::factory()->count(15)->create();
        $hadiahs = Hadiah::factory()->count(10)->create();

        foreach ($users as $user) {
            Penukaran::factory()->count(2)->create([
                'user_id' => $user->id,
                'hadiah_id' => $hadiahs->random()->id,
            ]);
        }

        $permintaans = Permintaan::factory()->count(10)->create();

        $transaksis = Transaksi::factory()->count(20)->create([
            'mesin_id' => $mesins->random()->id,
            'user_id' => $users->random()->id,
        ]);

        foreach ($transaksis as $transaksi) {
            Sampah::factory()->count(3)->create([
                'transaksi_id' => $transaksi->id,
            ]);
        }
    }
}
