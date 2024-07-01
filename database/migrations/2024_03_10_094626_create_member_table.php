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
        Schema::create('member', function (Blueprint $table) {
            $table->id('mNo');
            $table->string('mID', 30);
            $table->string('mPW', 100);
            $table->unsignedTinyInteger('mWrongPWCount')->default(0);
            $table->string('mRealName', 50)->nullable();
            $table->string('mNick', 50)->nullable();
            $table->string('mLevel', 2)->default(1)->comment('MA: master admin, AD: admin manager, [1,2,3,4,5,6,7,8,9]: member normal');
            $table->string('mOption', 255)->nullable();
            $table->string('mPhone', 50)->nullable();
            $table->string('mPhoneCom', 50)->nullable();
            $table->char('mStatus', 1)->default(9)->comment('9: normal, 8: Stop, 7: Member in Black list, 3: Lock by wrong password, 2: Stop by admin, 1: Pending');
            $table->dateTime('mStatusDateTime')->nullable();
            $table->decimal('mPoint', 20, 2)->nullable();
            $table->decimal('mPointDeposit', 20, 2)->nullable();
            $table->decimal('mPointWithraw', 20, 2)->nullable();
            $table->decimal('mMoneyDeposit', 20, 2)->nullable();
            $table->decimal('mMoneyWidraw', 20, 2)->nullable();
            $table->unsignedInteger('mMoneyCount')->nullable();
            $table->decimal('mSportsMoney', 20, 2)->nullable();
            $table->decimal('mSportsMoneyDeposit', 20, 2)->nullable();
            $table->decimal('mSportsMoneyWidraw', 20, 2)->nullable();
            $table->decimal('mGameMoney', 20, 2)->nullable();
            $table->decimal('mGameMoneyDeposit', 20, 2)->nullable();
            $table->decimal('mGameMoneyWidraw', 20, 2)->nullable();
            $table->string('mBankName', 50)->nullable();
            $table->string('mBankNumber', 50)->nullable();
            $table->string('mBankOwner', 50)->nullable();
            $table->string('mBankExchangePW', 50)->nullable();
            $table->string('mLoginIP', 50)->nullable()->comment('IPv4(example): 1.1.1.1, 192.1.1.1, 123.123.123.123');
            $table->dateTime('mLoginDateTime')->nullable();
            $table->dateTime('mModifyDateTime')->nullable();
            $table->dateTime('mRegDate')->default(now());
            $table->dateTime('mApproveRegDate')->nullable();
            $table->text('mNote')->nullable();
            $table->unsignedBigInteger('mMemberID')->nullable()->comment('This is mNo of presenter');
            $table->string('mEtcVarchar1', 50)->nullable();
            $table->string('mEtcVarchar2', 50)->nullable();
            $table->string('mEtcVarchar3', 50)->nullable();
            $table->string('mEtcVarchar4', 50)->nullable();
            $table->string('mEtcVarchar5', 50)->nullable();
            $table->string('mEtcVarchar6', 50)->nullable();
            $table->string('mEtcVarchar7', 50)->nullable();
            $table->string('mEtcVarchar8', 50)->nullable();
            $table->string('mEtcVarchar9', 50)->nullable();
            $table->longText('mBanProviders')->nullable();
            $table->longText('mBanGames')->nullable();

            //foreign
            $table->index('mID', 'member_mID');
            $table->index('mMemberID', 'member_mMemberID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member');
    }
};
