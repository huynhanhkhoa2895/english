<?php

namespace App\Providers;

use App\Filament\Resources\PracticeResource;
use App\Interface\LessonInterface;
use App\Interface\PracticeInterface;
use App\Interface\SubmitInterface;
use App\Interface\VocabularyInterface;
use App\Interface\ZipInterface;
use App\Interface\StudentInterface;
use App\Interface\ResultInterface;
use App\Interface\InterviewQuestionInterface;
use App\Interface\GoogleInterface;
use App\Services\LessonService;
use App\Services\InterviewQuestionService;
use App\Services\PracticeService;
use App\Services\GoogleService;
use App\Services\SubmitService;
use App\Services\VocabularyService;
use App\Services\ZipService;
use App\Services\StudentService;
use App\Services\ResultService;
use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\URL;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(GoogleInterface::class, GoogleService::class);
        $this->app->bind(VocabularyInterface::class, VocabularyService::class);
        $this->app->bind(LessonInterface::class, LessonService::class);
        $this->app->bind(ZipInterface::class, ZipService::class);
        $this->app->bind(PracticeInterface::class, PracticeService::class);
        $this->app->bind(StudentInterface::class, StudentService::class);
        $this->app->bind(ResultInterface::class, ResultService::class);
        $this->app->bind(SubmitInterface::class, SubmitService::class);
        $this->app->bind(InterviewQuestionInterface::class, InterviewQuestionService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Filament::serving(function () {
            Filament::registerStyles([
                'resources/css/app.css',
            ]);
            Filament::registerNavigationItems([
                NavigationItem::make('Result')
                    ->url(PracticeResource::getUrl('result'))
                    ->icon('heroicon-o-presentation-chart-line')
                    ->group('Practice')
            ]);
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Practice')
                    ->icon('heroicon-o-academic-cap'),
            ]);
        });
    }
}
