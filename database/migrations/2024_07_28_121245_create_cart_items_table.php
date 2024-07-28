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
        Schema::create('cart_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id')->references('cart_id')->on('cart');
            $table->unsignedBigInteger('product_id')->references('product_id')->on('product');
            $table->unsignedBigInteger('promotion_id')->references('promotion_id')->on('promotion');
            $table->integer('quantity');
            $table->decimal('subtotal', 8, 2);
            $table->string('discount');
            $table->decimal('total', 8, 2);
            $table->timestamps();

            $table->unique(['cart_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_item');
    }
};
