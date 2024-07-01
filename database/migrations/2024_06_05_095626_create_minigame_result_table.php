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
        Schema::create('minigame_result', function (Blueprint $table) {
            $table->increments('mgrNo')->primary();
            $table->integer('mgrRound')->nullable();
            $table->string('mgrMode', 255)->nullable();
            $table->longText('mgrResult');
            $table->integer('mgNo');
            $table->datetime('mgrRegDate');
            $table->datetime('mgrUpdateDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minigame_result');
    }
};
