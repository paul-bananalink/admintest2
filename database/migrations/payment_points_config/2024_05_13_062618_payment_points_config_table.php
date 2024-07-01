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
        Schema::create('payment_points_config', function (Blueprint $table) {
            $table->integer("ppcNo")->autoIncrement();
            $table->string("ppcType", 20)->nullable();
            $table->boolean('ppcResetRollingBonusIsPaid')->default(true);
            $table->boolean('ppcIsCheckBalanceUponPayout')->default(true);
            $table->float('ppcAmountPaid')->default(0);

            $table->longText('ppcWeekdayRate')->nullable();
            $table->longText('ppcWeekendRate')->nullable();
            $table->longText('ppcIsPaymentUponWithdrawal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_points_config');
    }
};
