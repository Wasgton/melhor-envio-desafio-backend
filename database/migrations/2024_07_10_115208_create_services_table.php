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
            $table->id();
            $table->uuid('service_original_id');
            $table->unsignedBigInteger('request_id');
            $table->string('name');
            $table->string('host');
            $table->integer('port');
            $table->string('protocol');
            $table->integer('connect_timeout');
            $table->integer('read_timeout');
            $table->integer('write_timeout');
            $table->integer('retries');
            $table->timestamps();
            
            $table->foreign('request_id')->references('id')->on('requests');
        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
};