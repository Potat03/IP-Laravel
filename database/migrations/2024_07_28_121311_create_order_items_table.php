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
            $table->unsignedBigInteger('product_id')->nullable()->default(null)->references('product_id')->on('product');
            $table->unsignedBigInteger('promotion_id')->nullable()->default(null)->references('promotion_id')->on('promotion');    
            $table->integer('quantity');
            $table->decimal('subtotal', 8, 2);
            $table->string('discount')->nullable()->default(null);
            $table->decimal('total', 8, 2);
            $table->timestamps();

           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
