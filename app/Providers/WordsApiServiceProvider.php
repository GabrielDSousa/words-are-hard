<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\WordsApiService;

class WordsApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(WordsApiService::class, function ($app) {
            return new WordsApiService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
