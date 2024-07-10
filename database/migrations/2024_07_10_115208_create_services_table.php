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
        Schema::create('services', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('service_original_id');
            $table->uuid('log_id');
            $table->string('name');
            $table->string('host');
            $table->integer('port');
            $table->string('protocol');
            $table->integer('connect_timeout');
            $table->integer('read_timeout');
            $table->integer('write_timeout');
            $table->integer('retries');

            $table->foreign('log_id')->references('id')->on('logs');
        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
};