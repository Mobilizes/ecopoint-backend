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
            'total_poin' => 99999999,
            'poin' => 99999999,
        ]);

        $test_hadiahs = Hadiah::factory(100)->create([]);

        $test_penukaran = Penukaran::factory(5)->create([
            'user_id' => $test_user->id,
        ]);

        foreach ($test_penukaran as $penukaran) {
            $hadiahs = $test_hadiahs->random(3);

            foreach ($hadiahs as $hadiah) {
                $penukaran->hadiahs()->attach([
                    'hadiah_id' => $hadiah->id,
                ]);
            }
        }

        $test_mesins = Mesin::factory(3)->create([]);

        foreach ($test_mesins as $test_mesin) {
            $test_permintaan = Permintaan::factory()->create([
                'mesin_id' => $test_mesin->id,
                'kode_verifikasi' => 87142,
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

        /* $mesins = Mesin::factory()->count(5)->create(); */
        /**/
        $users = User::factory()->count(8)->create();
        /* $hadiahs = Hadiah::factory()->count(10)->create(); */
        /**/
        /* foreach ($users as $user) { */
        /*     Penukaran::factory()->count(2)->create([ */
        /*         'user_id' => $user->id, */
        /*     ]); */
        /* } */
        /**/
        /* $permintaans = Permintaan::factory()->count(10)->create(); */
        /**/
        /* $transaksis = Transaksi::factory()->count(20)->create([ */
        /*     'mesin_id' => $mesins->random()->id, */
        /*     'user_id' => $users->random()->id, */
        /* ]); */
        /**/
        /* foreach ($transaksis as $transaksi) { */
        /*     Sampah::factory()->count(3)->create([ */
        /*         'transaksi_id' => $transaksi->id, */
        /*     ]); */
        /* } */
    }
}
