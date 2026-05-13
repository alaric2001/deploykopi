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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name_user');
            $table->enum('role', ['admin','pemilik', 'user'])->default('user')->nullable();
            $table->string('password');
            // $table->string('username')->nullable();
            $table->string('user_jenis_kelamin')->nullable();
            $table->string('user_foto')->nullable();
            // $table->tinyInteger('user_status')->nullable();
            $table->text('alamat')->nullable();
            $table->bigInteger('no_hp')->nullable();
            // $table->integer('no_hp')->length(15)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            // $table->tinyInteger('level');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
