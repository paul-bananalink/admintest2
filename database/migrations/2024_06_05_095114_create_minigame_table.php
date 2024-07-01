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
        Schema::create('minigame', function (Blueprint $table) {
            $table->increments('mgNo')->primary();
            $table->string('mgName', 255)->nullable();
            $table->string('mgNameEn', 255)->nullable();
            $table->string('mgType', 255)->nullable();
            $table->integer('mgOrder')->default(0);
            $table->integer('mgcNo')->default(1);
            $table->datetime('mgRegDate');
            $table->datetime('mgUpdateDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minigame');
    }
};
