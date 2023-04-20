<?php

namespace App\Providers;

use App\Interface\LessonInterface;
use App\Interface\PracticeInterface;
use App\Interface\ReceiveInterface;
use App\Interface\VocabularyInterface;
use App\Interface\ZipInterface;
use App\Interface\StudentInterface;
use App\Interface\ResultInterface;
use App\Services\LessonService;
use App\Services\PracticeService;
use App\Services\ReceiveService;
use App\Services\VocabularyService;
use App\Services\ZipService;
use App\Services\StudentService;
use App\Services\ResultService;
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
        $this->app->bind(ZipInterface::class, ZipService::class);
        $this->app->bind(PracticeInterface::class, PracticeService::class);
        $this->app->bind(StudentInterface::class, StudentService::class);
        $this->app->bind(ResultInterface::class, ResultService::class);
        $this->app->bind(ReceiveInterface::class, ReceiveService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
