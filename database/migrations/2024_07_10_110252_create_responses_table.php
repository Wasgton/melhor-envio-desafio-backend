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
            $table->uuid('id')->primary();
            $table->integer('status');
            $table->integer('size');
            $table->json('headers');
            $table->foreignUuid('log_id')
                ->index()
                ->constrained();
        });
    }

    public function down()
    {
        Schema::dropIfExists('responses');
    }
};