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
        Schema::create('members_login', function (Blueprint $table) {
            $table->id('mlNo');
            $table->unsignedBigInteger('mNo');
            $table->ipAddress('mlIpv4');
            $table->string('mlBrowserSystem');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members_login');
    }
};
