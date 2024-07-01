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
        Schema::create('member_allow_ip', function (Blueprint $table) {
            $table->id('maiNo');
            $table->string('mID', 30);
            $table->ipAddress('maiIp');
            $table->timestamp('maiRegDate');

            //foreign
            $table->index('mID', 'member_allow_ip_mID');
            $table->foreign('mID')->references('mID')->on('member')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_allow_ip');
    }
};
