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
            $table->unsignedBigInteger('customer_id')->references('customer_id')->on('cart');
            $table->unsignedBigInteger('product_id')->references('product_id')->on('product')->nullable();
            $table->unsignedBigInteger('promotion_id')->references('promotion_id')->on('promotion')->nullable();
            $table->integer('quantity');
            $table->string('details');
            $table->decimal('subtotal', 8, 2);
            $table->decimal('discount', 8, 2);
            $table->decimal('total', 8, 2);
            $table->timestamps();
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
