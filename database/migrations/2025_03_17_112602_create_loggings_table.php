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
        Schema::create('loggings', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable(); // 1, 2
            $table->string('ip_address'); // 192.168.0.01
            $table->string('message'); // "todolist message"
            $table->string('action'); // GET, POST, PUT, PATCH, DELETE
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loggings');
    }
};
