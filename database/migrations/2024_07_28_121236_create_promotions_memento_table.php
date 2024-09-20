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
        Schema::create('promotion_memento', function (Blueprint $table) {
            $table->id('promotion_id');
            $table->string('title');
            $table->string('description');
            $table->string('discount');
            $table->decimal('discount_amount', 8, 2);
            $table->decimal('original_price', 8, 2);
            $table->string('type');
            $table->integer('limit');
            $table->date('start_at');
            $table->date('end_at');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_memento');
    }
};