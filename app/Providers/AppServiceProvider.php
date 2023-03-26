<?php

namespace App\Providers;

use App\Interface\VocabularyInterface;
use App\Services\VocabularyService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(VocabularyInterface::class, VocabularyService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
