<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('chat_messages', function (Blueprint $table) {

            $table->unsignedBigInteger('chat_id')->change();

            $table->dropPrimary('chat_id');

            $table->bigIncrements('message_id')->first(); 

            $table->foreign('chat_id')->references('chat_id')->on('chat')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropForeign(['chat_id']);
            
            $table->dropColumn('message_id');

            $table->bigIncrements('chat_id')->change()->first(); 
        });
    }
};
