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
        Schema::create('notice_config', function (Blueprint $table) {
            $table->increments('ncNo')->primary();
            $table->integer('ntNo');
            $table->integer('ncNumberOfPollItems');
            $table->integer('ncPollDurationHour');
            $table->integer('ncVotingMemberLevel');
            $table->tinyInteger('ncEnableMultipleSelection')->default(1);
            $table->tinyInteger('ncEnablePollCancel')->default(1);
            $table->integer('ncDivideByItem');
            $table->string('ncItem1');
            $table->integer('ncValue1')->default(0);
            $table->string('ncItem2');
            $table->integer('ncValue2')->default(0);
            $table->string('ncItem3');
            $table->integer('ncValue3')->default(0);
            $table->string('ncItem4');
            $table->integer('ncValue4')->default(0);
            $table->string('ncItem5');
            $table->integer('ncValue5')->default(0);
            $table->datetime('ncRegDate');
            $table->datetime('ncUpdateDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notice_config');
    }
};
