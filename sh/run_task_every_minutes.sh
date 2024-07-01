#!/bin/bash
current_seconds=$(date +%S)

if [ "$current_seconds" -eq "00" ] && [ "$1" == "one-minutes" ]; then
  php artisan minigame:surepowerball one >> /dev/null 2>&1
fi

if [ "$current_seconds" -eq "00" ] && [ "$1" == "two-minutes" ]; then
  php artisan minigame:surepowerball two >> /dev/null 2>&1
fi

if [ "$current_seconds" -eq "00" ] && [ "$1" == "five-minutes" ]; then
  php artisan minigame:surepowerball three >> /dev/null 2>&1
fi
