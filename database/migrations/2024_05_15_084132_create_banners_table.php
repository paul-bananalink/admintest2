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
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('bNo')->primary();
            $table->string('bImage', 255)->nullable();
            $table->string('bLink', 255)->nullable();
            $table->string('bTarget', 255)->nullable();
            $table->tinyInteger('bStatus')->default(1);
            $table->string('bPosition')->nullable(0);
            $table->integer('bOrder')->default(0);
            $table->datetime('bRegDate');
            $table->datetime('bUpdateDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
