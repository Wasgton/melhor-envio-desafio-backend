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
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('log_id');
            $table->integer('status');
            $table->integer('size');
            $table->json('headers');
            
            $table->foreign('log_id')->references('id')->on('logs');
        });
    }

    public function down()
    {
        Schema::dropIfExists('responses');
    }
};