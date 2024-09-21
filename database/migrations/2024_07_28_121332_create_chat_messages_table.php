<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->unsignedBigInteger('chat_id');
            $table->bigIncrements('message_id'); 
            $table->boolean('by_customer');
            $table->text('message_content');
            $table->text('message_type');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable(false);
            $table->foreign('chat_id')->references('chat_id')->on('chat')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_message');
    }
};
