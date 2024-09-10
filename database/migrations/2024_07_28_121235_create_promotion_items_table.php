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
        Schema::create('promotion_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('promotion_id')->references('promotion_id')->on('promotion');
            $table->unsignedBigInteger('product_id')->references('product_id')->on('product');
            $table->integer('quantity');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_item');
    }
};
