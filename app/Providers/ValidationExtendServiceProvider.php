<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidationExtendServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Validator::extend('not_exists', function ($attribute, $value, $parameters) {
            return ! DB::table($parameters[0])
                ->where($parameters[1], $value)->exists();
        });
    }
}
