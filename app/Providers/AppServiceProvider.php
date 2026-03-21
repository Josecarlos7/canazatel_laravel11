<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $locale = 'es';
        $timezone = 'America/Manaus';

        config(['app.timezone' => $timezone]);
        date_default_timezone_set($timezone);
        app()->setLocale($locale);
        Carbon::setLocale($locale);

        // Ensure month/day names from strftime-compatible operations are in Spanish too.
        setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'es_MX.UTF-8', 'es_MX', 'Spanish_Spain.1252', 'Spanish');
    }
}
