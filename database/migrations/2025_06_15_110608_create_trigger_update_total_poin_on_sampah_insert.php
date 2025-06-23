<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER trg_update_total_poin_after_sampah_insert
            AFTER INSERT ON sampahs
            FOR EACH ROW
            BEGIN
                UPDATE transaksis
                SET total_poin = total_poin + NEW.poin
                WHERE id = NEW.transaksi_id;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_update_total_poin_after_sampah_insert');
    }
};
