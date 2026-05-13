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
        Schema::create('tbl_ingredient', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rawingredient_id')->nullable();
            $table->foreign('rawingredient_id')->references('id')->on('tbl_raw_ingredient')->onDelete('cascade');

            $table->unsignedBigInteger('kopi_id');
            $table->foreign('kopi_id')->references('id')->on('tbl_kopi')->onDelete('cascade');
            
            $table->integer('available')->default('1')->nullable();
            $table->string('nama_bahan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
