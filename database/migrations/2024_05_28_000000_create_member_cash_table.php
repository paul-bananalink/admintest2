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
        Schema::create('cash', function (Blueprint $table) {
            $table->increments('cNo')->primary();
            $table->string('cID');
            $table->string('cTable')->default('money_info');
            $table->decimal('mMoney', 20, 2)->nullable();
            $table->decimal('mSportsMoney', 20, 2)->nullable();
            $table->datetime('cRegDate');
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash');
    }
};
