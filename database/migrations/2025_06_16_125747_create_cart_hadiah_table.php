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
        Schema::create('cart_hadiah', function (Blueprint $table) {
            $table->uuid('cart_id');
            $table->uuid('hadiah_id');
            $table->integer('kuantitas')->default(1);
            $table->timestamps();

            $table->primary(['cart_id', 'hadiah_id']);
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('hadiah_id')->references('id')->on('hadiahs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_hadiah');
    }
};
