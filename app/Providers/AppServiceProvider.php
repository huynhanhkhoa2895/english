<?php

namespace App\Providers;

use App\Interface\LessonInterface;
use App\Interface\VocabularyInterface;
use App\Services\LessonService;
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
        $this->app->bind(LessonInterface::class, LessonService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
