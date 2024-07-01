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
        Schema::create('withdraw_config', function (Blueprint $table) {
            $table->increments('wcNo')->primary();
            $table->decimal('wcMinWithdraw', 20, 2);
            $table->integer('wcDelayTime');
            $table->tinyInteger('wcEnableDelayTime')->default(1);
            $table->tinyInteger('wcAutoPayRoll')->default(1);
            $table->text('wcRollingRules')->nullable();
            $table->tinyInteger('wcManualWithdraw')->default(1);
            $table->text('wcTimeOffWithdraw')->nullable();
            $table->tinyInteger('wcEnableWithdraw')->default(1);
            $table->longText('wcDisableWithdrawContent')->nullable();
            $table->longText('wcMaxRechargePerDay')->nullable();
            $table->longText('wcMaxRechargePerTime')->nullable();
            $table->longText('wcNoBonus')->nullable();
            $table->longText('wcBonus')->nullable();
            $table->longText('wcWithdrawRules')->nullable();
            $table->datetime('wcRegDate');
            $table->datetime('wcUpdateDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraw_config');
    }
};
