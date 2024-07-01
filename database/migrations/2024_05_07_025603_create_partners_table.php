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
        Schema::create('partners', function (Blueprint $table) {
            $table->increments('pNo')->primary();
            $table->string('mID');
            $table->string('pType');
            $table->string('pName');
            $table->float('pCommissions');
            $table->string('pProfitType');
            $table->string('pNote')->nullable();
            $table->tinyInteger('pIsCoupon')->default(0);
            $table->tinyInteger('pIsAutoPayRoulette')->default(0);
            $table->datetime('pRegDate');
            $table->datetime('pUpdateDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
