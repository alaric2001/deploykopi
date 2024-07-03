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
        // Schema::create('tbl_barang', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name_barang');
        //     $table->text('desc_barang');
        //     $table->string('foto_barang');
        //     $table->float('harga_barang');
        //     $table->unsignedBigInteger('id_category');
        //     $table->foreign('id_category')->references('id')->on('tbl_category')->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_barang');
    }
};
