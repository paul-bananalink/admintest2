<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('minigame:ntry')->everyFiveMinutes();

Schedule::command('minigame:surepowerball one')->everyMinute();
Schedule::command('minigame:surepowerball two')->everyTwoMinutes();
Schedule::command('minigame:surepowerball thr')->everyThreeMinutes();

Schedule::command('minigame:game365')->everyFiveMinutes();

