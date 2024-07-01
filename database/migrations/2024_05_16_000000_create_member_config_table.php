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
        Schema::create('member_config', function (Blueprint $table) {
            $table->increments('mcNo')->primary();
            $table->string('mID');
            $table->tinyInteger('mcForceLogout')->default(0);
            $table->tinyInteger('mcIsRechargeLimit')->default(0);
            $table->tinyInteger('mcIsWithdrawLimit')->default(0);
            $table->tinyInteger('mcIsBlackList')->default(0);
            $table->tinyInteger('mcSport')->default(1);
            $table->tinyInteger('mcMiniGame')->default(1);
            $table->tinyInteger('mcCasino')->default(1);
            $table->tinyInteger('mcSlot')->default(1);
            $table->tinyInteger('mcEnableSinglePole')->default(1);
            $table->decimal('mcSinglePoleAmount', 20, 2)->nullable();
            $table->tinyInteger('mcEnableMultiPole')->default(1);
            $table->decimal('mcMultiPoleAmount', 20, 2)->nullable();
            $table->tinyInteger('mcSportsRolling')->default(0);
            $table->tinyInteger('mcCasinoRolling')->default(0);
            $table->datetime('mcRegDate');
            $table->datetime('mcUpdateDate');
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_config');
    }
};
