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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');
            $table->longText('content_reply')->nullable();
            $table->integer('mNo')->nullable();
            $table->integer('mNo_receive')->nullable();
            $table->dateTime('date_feedback')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('views')->default(0);
            $table->tinyInteger('show_ui')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
