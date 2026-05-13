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
        // Schema::create('tbl_rasa_kopi', function (Blueprint $table) {
        //     $table->id();
        //     // // Foreign key ke tabel kopi
        //     $table->unsignedBigInteger('kopi_id');
        //     $table->foreign('kopi_id')->references('id')->on('tbl_kopi')->onDelete('cascade');
        //     $table->string('nama_rasa');
        //     $table->timestamps();

        //     // $table->integer('stock');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_rasa_kopi');
    }
};
