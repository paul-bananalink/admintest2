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
        Schema::create('display', function (Blueprint $table) {
            $table->increments('dpNo')->primary();
            $table->string('dpTable', 255);
            $table->longText('dpData',)->nullable();
            $table->datetime('dpRegDate');
            $table->datetime('dpUpdateDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('display');
    }
};
