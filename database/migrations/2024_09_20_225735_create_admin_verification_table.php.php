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
        Schema::create('adminverification', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->references('admin_id')->on(table: 'admin');
            $table->string('code');
            $table->string('status');
            $table->dateTime('expired_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adminverification');
    }
};
