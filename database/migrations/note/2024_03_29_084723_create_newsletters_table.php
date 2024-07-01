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
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type');
            $table->string('title');
            $table->longText('content');
            $table->integer('mNo_writer');
            $table->longText('noticed')->nullable();
            $table->dateTime('created_date')->nullable();
            $table->integer('views')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('show_ui')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletters');
    }
};
