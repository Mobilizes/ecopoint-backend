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
        Schema::create('penukaran_hadiah', function (Blueprint $table) {
            $table->uuid('penukaran_id');
            $table->uuid('hadiah_id');
            $table->integer('kuantitas')->default(1);
            $table->timestamps();

            $table->primary(['penukaran_id', 'hadiah_id']);
            $table->foreign('penukaran_id')->references('id')->on('penukarans')->onDelete('cascade');
            $table->foreign('hadiah_id')->references('id')->on('hadiahs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penukaran_hadiah');
    }
};
