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
        Schema::create('requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('method');
            $table->string('uri');
            $table->string('url');
            $table->integer('size');
            $table->json('querystring');
            $table->json('headers');
            $table->uuid('log_id');

            $table->foreign('log_id')->references('id')->on('logs');
        });
    }

    public function down()
    {
        Schema::dropIfExists('requests');
    }
};
