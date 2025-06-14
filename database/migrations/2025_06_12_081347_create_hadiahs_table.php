<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hadiahs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_hadiah');
            $table->integer('poin')->default(0);
            $table->float('rating')->default(0)->check('rating >= 0 and rating <= 5');
            $table->integer('jumlah_penukaran')->default(0);
            $table->string('link_foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hadiahs');
    }
};
