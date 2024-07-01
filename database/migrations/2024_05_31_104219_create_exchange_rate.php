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
        Schema::create('exchange_rate', function (Blueprint $table) {
            // $table->id();
            $table->float('rSoccer');
            $table->float('rBasketball');
            $table->float('rBaseball');
            $table->float('rVolleyball');
            $table->float('rIce_hockey');
            $table->float('rTable_tennis');
            $table->float('rHandball');
            $table->float('rTennis');
            $table->float('rAmerican_football');
            $table->float('rEsports');
            $table->float('rBoxing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_rate');
    }
};
