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
        Schema::create('auto_reply', function (Blueprint $table) {
            $table->increments('arNo')->primary();
            $table->string('arLink', 255)->nullable();
            $table->string('arLevel', 255)->nullable();
            $table->longText('content')->nullable();
            $table->datetime('arRegDate');
            $table->datetime('arUpdateDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auto_reply');
    }
};
