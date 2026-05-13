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
        Schema::create('tbl_jenis_kopi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kopi_id');
            $table->foreign('kopi_id')->references('id')->on('tbl_kopi')->onDelete('cascade');
            $table->unsignedBigInteger('id_rawjeniskopi');
            $table->foreign('id_rawjeniskopi')->references('id')->on('tbl_raw_jenis_kopi')->onDelete('cascade');
            $table->integer('ready')->default('1')->nullable();
            $table->string('nama_jenis')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_kopis');
    }
};
