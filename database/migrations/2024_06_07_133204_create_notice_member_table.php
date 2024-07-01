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
        Schema::create('notice_member', function (Blueprint $table) {
            $table->increments('nmNo')->primary();
            $table->string('mID');
            $table->integer('ntNo');
            $table->tinyInteger('nmRead')->default(0);
            $table->datetime('nmRegDate');
            $table->datetime('nmUpdateDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notice_member');
    }
};
