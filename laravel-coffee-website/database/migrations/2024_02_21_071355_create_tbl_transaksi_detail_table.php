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
        // Schema::create('tbl_transaksi_detail', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('id_transaksi');
        //     $table->foreign('id_transaksi')->references('id')->on('tbl_transaksi')->onDelete('cascade');
            
        //     $table->unsignedBigInteger('id_barang');
        //     $table->foreign('id_barang')->references('id')->on('tbl_barang')->onDelete('cascade');
        //     $table->float('harga_transaksi');
        //     $table->integer('jumlah_transaksi');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_transaksi_detail');
    }
};
