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
        Schema::create('transaction', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('mID', 63);
            $table->string('pCode', 31);
            $table->string('gCode', 255)->nullable();
            $table->string('gName', 255)->nullable();
            $table->string('gNameEn', 255)->nullable();
            $table->string('gCategory', 31)->nullable();
            $table->string('tRoundId', 70)->nullable();
            $table->string('tType', 10);
            $table->decimal('tAmount', 20, 2);
            $table->string('tReferenceUuid', 80)->nullable();
            $table->boolean('tRoundStarted');
            $table->boolean('tRoundFinished');
            $table->string('tDetails')->nullable();
            $table->datetime('tRegDate');
            $table->datetime('tUpdateDate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
