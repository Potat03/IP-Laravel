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
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->references('order_id')->on('order');
            $table->unsignedBigInteger('customer_id')->references('customer_id')->on('customer');
            $table->string('payment_ref');
            $table->decimal('amount', 8, 2);
            $table->string('method');
            $table->date('paid_at');
            $table->string('status');
            $table->timestamps();

            $table->unique(['order_id', 'customer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
