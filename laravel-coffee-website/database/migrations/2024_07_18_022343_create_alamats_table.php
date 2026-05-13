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
        // Schema::create('tbl_alamat', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('id_user');
        //     $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        //     $table->string('kab_kota');
        //     $table->string('kec');
        //     $table->string('kel');
        //     $table->BigInteger('kodepos');
        //     $table->text('detail')->nullable();
        //     $table->integer('harga_ongkir')->nullable();
        //     $table->timestamps();
        // });
        Schema::create('tbl_raw_ingredient', function (Blueprint $table) {
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
        // Schema::dropIfExists('alamats');
        Schema::dropIfExists('tbl_raw_ingredient');
    }
};
