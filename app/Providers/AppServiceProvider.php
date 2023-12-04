<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TranslatorService;
use Illuminate\Contracts\Foundation\Application;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->scoped(TranslatorService::class, function (Application $app) {
            $keyFilePath = config('app.google_key_file');
            return new TranslatorService($keyFilePath);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
