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
        // Schema::create('tbl_city', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name_city');
        //     $table->unsignedBigInteger('id_province');
        //     $table->foreign('id_province')->references('id')->on('tbl_province')->onDelete('cascade');
        //     $table->string('type');
        //     $table->string('postal_code');
        //     $table->integer('id_city_auto');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_city');
    }
};
