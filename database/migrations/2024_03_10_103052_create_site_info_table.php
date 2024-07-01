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
        Schema::create('site_info', function (Blueprint $table) {
            $table->id('siNo');
            $table->string('siName', 50)->nullable();
            $table->string('siEmail', 50)->nullable();
            $table->string('siTel', 50)->nullable();
            $table->string('siMainNotice', 255)->nullable();
            $table->string('siGameNotice', 255)->nullable();
            $table->string('siBank', 50)->nullable();
            $table->string('siOwner', 50)->nullable();
            $table->string('siBankAccount', 50)->nullable();
            $table->string('siDescription', 255)->nullable();
            $table->string('siKeywords', 255)->nullable();
            $table->string('siAuthor', 255)->nullable();
            $table->string('siCorpName', 255)->nullable();
            $table->unsignedInteger('siMoneyDBDay')->nullable();
            $table->unsignedInteger('siBetDBDay')->nullable();
            $table->unsignedInteger('siBoardDBDay')->nullable();
            $table->char('siOpenType', 255)->nullable();
            $table->text('siOpenTypeText');
            $table->char('siOpenUserJoin', 255)->nullable();
            $table->char('siOpenGame', 255)->nullable();
            $table->unsignedInteger('siTimeOUt')->nullable();
            $table->char('siOptionAutoApprove', 255)->nullable();
            $table->char('siOptionRecommender', 255)->nullable();
            $table->decimal('siOptionMinDeposit', 20, 2)->nullable();
            $table->text('siOptionDepositText')->nullable();
            $table->decimal('siOptionMinWithraw', 20, 2)->nullable();
            $table->text('siOptionWithrawText')->nullable();
            $table->dateTime('siOptionRestTime')->nullable();
            $table->unsignedInteger('siOptionWithrawRepeat')->nullable();
            $table->decimal('siOptionMinBet', 20, 2)->nullable();
            $table->decimal('siOptionExchangePoint', 20, 2)->nullable();
            $table->boolean('siIsGameProviderCasino')->default(true);
            $table->boolean('siIsGameProviderSlot')->default(true);
            $table->float('siSportsBettingRate')->default(0.5);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_info');
    }
};
