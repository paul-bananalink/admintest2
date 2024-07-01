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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');
            $table->tinyInteger('type');
            $table->integer('mNo');
            $table->integer('mNo_receive')->nullable();
            $table->json('mNo_receive_list')->nullable();
            $table->tinyInteger('is_read')->default(0);
            $table->dateTime('date_read')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('show_ui')->default(1);
            $table->longText('content');
            $table->longText('noticed')->nullable();
            $table->longText('deleted_by_list')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
