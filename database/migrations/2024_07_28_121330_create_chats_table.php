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
        Schema::create('chat', function (Blueprint $table) {
            $table->id('chat_id');
            $table->unsignedBigInteger('customer_id')->references('customer_id')->on('customer');
            $table->unsignedBigInteger('admin_id')->references('admin_id')->on('admin');
            $table->string('status');
            $table->date('ended_at');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat');
    }
};
