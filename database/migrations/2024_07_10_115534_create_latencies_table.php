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
            $table->uuid('id')->primary();
            $table->integer('proxy');
            $table->integer('gateway');
            $table->integer('request');
            $table->foreignUuid('log_id')
                ->index()
                ->constrained();
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
