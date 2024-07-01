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
        Schema::create('domain_web', function (Blueprint $table) {
            $table->increments('dNo')->primary();
            $table->string('dDomain', 255);
            $table->string('dPartNer', 255);
            $table->string('dPartNerName', 255);
            $table->string('dCode', 255);
            $table->string('dName', 255);
            $table->string('dTitle', 255);
            $table->string('dNote', 255)->nullable();
            $table->boolean('dIsMain')->default(0);
            $table->boolean('dIsRefresh')->default(0);
            $table->datetime('dRegDate');
            $table->datetime('dUpdateDate');
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
