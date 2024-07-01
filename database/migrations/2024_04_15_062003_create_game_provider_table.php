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
        Schema::create('game_provider', function (Blueprint $table) {
            $table->increments('gpNo')->primary();
            $table->string('gpCode', 50);
            $table->string('gpName', 255)->nullable();
            $table->string('gpNameEn', 255)->nullable();
            $table->string('gpCategory', 255)->nullable();
            $table->boolean('gpIsGameProvider')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_provider');
    }
};
