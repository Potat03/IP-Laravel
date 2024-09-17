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
        Schema::create('order', function (Blueprint $table) {
            $table->id('order_id');
            $table->unsignedBigInteger('customer_id')->references('customer_id')->on('customer');
            $table->decimal('subtotal', 8, 2);
            $table->decimal('total_discount', 8, 2);
            $table->decimal('total', 8, 2);
            $table->string('status');
            $table->string('delivery_address');
            $table->string('tracking_number')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
