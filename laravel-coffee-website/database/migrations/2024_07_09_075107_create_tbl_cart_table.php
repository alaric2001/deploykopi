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
        Schema::create('tbl_cart', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');

            // Foreign key ke tabel kopi
            $table->unsignedBigInteger('kopi_id');
            $table->foreign('kopi_id')->references('id')->on('tbl_kopi')->onDelete('cascade');

            $table->unsignedBigInteger('jenis_kopi_id')->nullable();
            $table->foreign('jenis_kopi_id')->references('id')->on('tbl_jenis_kopi')->onDelete('cascade');

            $table->unsignedBigInteger('transaksi_id')->nullable();
            $table->foreign('transaksi_id')->references('id')->on('tbl_transaksi')->onDelete('cascade')->nullable();

            $table->integer('quantity');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_cart');
    }
};
