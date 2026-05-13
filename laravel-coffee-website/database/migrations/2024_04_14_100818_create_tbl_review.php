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
        // Schema::create('tbl_review', function (Blueprint $table) {
        //     $table->id();

        //     // Foreign key ke tabel kopi
        //     $table->unsignedBigInteger('kopi_id');
        //     $table->foreign('kopi_id')->references('id')->on('tbl_kopi')->onDelete('cascade');

        //     // Foreign key ke tabel user
        //     $table->unsignedBigInteger('user_id');
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        //     $table->integer('bintang');
        //     $table->string('deskripsi');
        //     $table->timestamps();
        // });
        Schema::create('tbl_raw_jenis_kopi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('stok')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('tbl_review');
        Schema::dropIfExists('tbl_raw_jenis_kopi');
    }
};
