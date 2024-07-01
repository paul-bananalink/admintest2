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
        Schema::create('notice', function (Blueprint $table) {
            $table->increments('ntNo')->primary();
            $table->string('ntTitle');
            $table->longText('ntContent')->nullable();
            $table->tinyInteger('ntStatus')->default(1);
            $table->string('ntLogo')->nullable();
            $table->string('ntImage')->nullable();
            $table->datetime('ntRegDate');
            $table->datetime('ntUpdateDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notice');
    }
};
