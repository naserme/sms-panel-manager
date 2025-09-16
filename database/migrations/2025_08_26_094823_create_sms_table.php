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
        Schema::create('sms', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->integer('sms_id');
            $table->string('number');
            $table->string('sms')->nullable();
            $table->integer('cost')->default(100);
            $table->timestamps();
            $table->tinyInteger('api')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms');
    }
};
