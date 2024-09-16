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
        Schema::create('wearable', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->references('product_id')->on('product');
            $table->string('size');
            $table->string('color');
            $table->string('user_group');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wearable');
    }
};
