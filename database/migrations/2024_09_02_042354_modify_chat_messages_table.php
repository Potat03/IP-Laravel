<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropColumn('updated_at');
            $table->boolean('by_customer')->change();
        });
    }


    public function down(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->timestamp('updated_at');
            $table->bigInteger('by_customer')->change();
        });
    }
};
