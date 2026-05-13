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
        Schema::create('tbl_kel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kec');
            $table->foreign('id_kec')->references('id')->on('tbl_kec')->onDelete('cascade');
            $table->string('nama_kel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelurahans');
    }
};
