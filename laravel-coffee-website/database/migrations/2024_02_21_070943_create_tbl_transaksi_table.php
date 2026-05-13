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
        Schema::create('tbl_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('id_alamat')->nullable();
            $table->foreign('id_alamat')->references('id')->on('tbl_alamat')->onDelete('cascade');
            
            $table->bigInteger('total_price')->nullable();
            
            $table->string('bukti_payment')->nullable();
            $table->enum('delivery', ['yes', 'no'])->default('no')->nullable();
            // $table->integer('no_meja')->nullable();
            
            $table->enum('order_telah_diantar', ['Belum diantar', 'Sudah diantar'])->default('Belum Diantar')->nullable();
            
            // $table->enum('order_telah_diantar', ['yes', 'no'])->nullable();
            // $table->integer('no_transaksi');
            // $table->date('tgl_transaksi');
            // $table->enum('status_transaksi', ['Unpaid', 'Paid'])->nullable();
            // $table->text('address')->nullable();
            // $table->bigInteger('phone')->nullable();
            // $table->integer('qty')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_transaksi');
    }
};
