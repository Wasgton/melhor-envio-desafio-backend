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
            $table->id();
            $table->string('method');
            $table->string('uri');
            $table->string('url');
            $table->integer('size');
            $table->json('querystring');
            $table->json('headers');
            $table->uuid('consumer_id');
            $table->string('upstream_uri');
            $table->string('client_ip');
            $table->integer('started_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('requests');
    }
};
