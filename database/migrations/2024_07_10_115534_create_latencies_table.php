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
        Schema::create('latencies', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('log_id');
            $table->integer('proxy');
            $table->integer('gateway');
            $table->integer('request');

            $table->foreign('log_id')->references('id')->on('logs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('latencies');
    }
};
