<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Hadiah;
use App\Models\Penukaran;
use App\Models\Permintaan;
use App\Models\Sampah;
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

        $test_hadiah = Hadiah::factory()->create([
            'nama_hadiah' => 'Test Hadiah',
            'poin' => 10,
            'rating' => 5,
            'jumlah_penukaran' => 10,
            'link_foto' => 'https://example.com/test-hadiah.jpg',
        ]);

        $test_penukaran = Penukaran::factory()->create([
            'user_id' => $test_user->id,
            'hadiah_id' => $test_hadiah->id,
        ]);

        $test_permintaan = Permintaan::factory()->create();

        $test_sampah = Sampah::factory()->create([
            'permintaan_id' => $test_permintaan->id,
            'user_id' => $test_user->id,
            'kategori_sampah' => 'kaca',
            'berat_sampah' => 100.0,
        ]);
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->seed_test();

        $users = User::factory()->count(5)->create();
        $hadiahs = Hadiah::factory()->count(3)->create();

        foreach ($users as $user) {
            Penukaran::factory()->count(2)->create([
                'user_id' => $user->id,
                'hadiah_id' => $hadiahs->random()->id,
            ]);
        }

        $permintaans = Permintaan::factory()->count(5)->create();

        foreach ($permintaans as $permintaan) {
            Sampah::factory()->count(3)->create([
                'permintaan_id' => $permintaan->id,
                'user_id' => $users->random()->id,
            ]);
        }
    }
}
