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
        Schema::create('recharge_config', function (Blueprint $table) {
            $table->increments('rcNo')->primary();
            $table->decimal('rcMinRecharge', 20, 2);
            $table->integer('rcDelayTime');
            $table->tinyInteger('rcEnableRecharge')->default(1);
            $table->tinyInteger('rcAutoBonus')->default(1);
            $table->decimal('rcMaxBonusFirstTimeSportsRecharge', 20, 2)->default(0);
            $table->decimal('rcMaxBonusSportsRecharge', 20, 2)->default(0);
            $table->decimal('rcMaxBonusFirstTimeCasinoRecharge', 20, 2)->default(0);
            $table->decimal('rcMaxBonusCasinoRecharge', 20, 2)->default(0);
            $table->string('rcDisableRechargeContent')->nullable();
            $table->longText('rcMaxRecharge')->nullable();
            $table->longText('rcWarningRechargeContent')->nullable();
            $table->datetime('rcRegDate');
            $table->datetime('rcUpdateDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recharge_config');
    }
};
