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
        Schema::create('member_login_failed', function (Blueprint $table) {
            $table->increments('mlfNo');
            $table->string('mID', 30);
            $table->string('mlfIP', 30);
            $table->string('mlfOS');
            $table->timestamp('mlfRegDate')->useCurrent();
            $table->string('mlfReason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_login_failed');
    }
};
