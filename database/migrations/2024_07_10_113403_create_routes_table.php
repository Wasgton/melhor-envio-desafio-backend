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
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('log_id');
            $table->uuid('route_original_id');//O id que está registrado no json original antes de ser persistido
            $table->string('hosts')->nullable();
            $table->json('methods');
            $table->json('paths');
            $table->boolean('preserve_host');
            $table->json('protocols');
            $table->integer('regex_priority');
            $table->uuid('service_original_id');
            $table->boolean('strip_path');

            $table->foreign('log_id')->references('id')->on('logs');
        });
    }

    public function down()
    {
        Schema::dropIfExists('routes');
    }
};