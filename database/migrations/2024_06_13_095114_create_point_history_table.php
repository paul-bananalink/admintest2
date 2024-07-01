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
        Schema::create('point_history', function (Blueprint $table) {
            $table->increments('phNo')->primary();
            $table->string('phID');
            $table->string('phTable');
            $table->decimal('phPoint', 20, 2)->default(0);
            $table->float('phExchangeRate')->nullable();
            $table->string('phToWallet')->nullable();
            $table->string('phDescription')->nullable();
            $table->datetime('phRegDate');
            $table->datetime('phUpdateDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_history');
    }
};
