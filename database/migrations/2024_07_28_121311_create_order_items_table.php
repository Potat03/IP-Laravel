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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->references('order_id')->on('orders');
            $table->unsignedBigInteger('product_id')->references('product_id')->on('products');
            $table->unsignedBigInteger('promotion_id')->references('promotion_id')->on('promotions')->nullable();
            $table->integer('quantity');
            $table->decimal('subtotal', 8, 2);
            $table->string('discount');
            $table->decimal('total', 8, 2);
            $table->timestamps();

            $table->unique(['order_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item');
    }
};
