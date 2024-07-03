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
        Schema::create('tbl_kopi', function (Blueprint $table) {
            $table->id();

            // Foreign key ke tabel rasa kopi
            // $table->unsignedBigInteger('rasa_id');
            // $table->foreign('rasa_id')->references('id')->on('tbl_rasa_kopi')->onDelete('cascade');

            $table->string('jenis_kopi');
            $table->string('foto');
            $table->float('harga');
            $table->integer('stok');
            $table->integer('diskon')->nullable();
            $table->string('deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_kopi');
    }
};
