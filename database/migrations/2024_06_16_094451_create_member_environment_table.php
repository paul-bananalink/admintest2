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
        Schema::create('member_environment', function (Blueprint $table) {
            $table->increments('meNo')->primary();
            $table->string('mID');
            $table->string('meType')->nullable();
            $table->string('meIP')->nullable();
            $table->string('meDeviceID')->nullable();
            $table->string('meOS')->nullable();
            $table->datetime('meRegDate');
            $table->datetime('meUpdateDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_environment');
    }
};
