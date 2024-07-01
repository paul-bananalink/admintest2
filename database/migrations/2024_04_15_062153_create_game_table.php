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
        Schema::create('game', function (Blueprint $table) {
            $table->increments('gNo')->primary();
            $table->string('gCode', 50);
            $table->string('gpCode', 50);
            $table->string('gName', 255)->nullable();
            $table->string('gNameEn', 255)->nullable();
            $table->string('gCategory', 255)->nullable();
            $table->text('gIconUrl')->nullable();
            $table->boolean('gStatus')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game');
    }
};
