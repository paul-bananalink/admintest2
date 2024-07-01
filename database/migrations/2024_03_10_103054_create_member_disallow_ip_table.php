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
        Schema::create('member_disallow_ip', function (Blueprint $table) {
            $table->id('mdiiNo');
            $table->string('mID', 30);
            $table->ipAddress('mdiIp');
            $table->timestamp('mdiRegDate');

            //foreign
            $table->index('mID', 'member_disallow_ip_mID');
            $table->foreign('mID')->references('mID')->on('member')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_disallow_ip');
    }
};
