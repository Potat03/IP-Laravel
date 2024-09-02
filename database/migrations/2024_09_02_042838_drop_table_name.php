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
        Schema::dropIfExists('chat_state');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('chat_state', function (Blueprint $table) {
            $table->bigInteger('chat_id');
            $table->string('status');
            $table->timestamps('created_at');
            $table->timestamps('updated_at');
        });
    }
};
