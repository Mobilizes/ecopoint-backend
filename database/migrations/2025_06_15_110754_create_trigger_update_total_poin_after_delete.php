<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER trg_update_total_poin_after_delete
            AFTER DELETE ON sampahs
            FOR EACH ROW
            BEGIN
                UPDATE transaksis
                SET total_poin = total_poin - OLD.poin
                WHERE id = OLD.transaksi_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_update_total_poin_after_delete');
    }
};
