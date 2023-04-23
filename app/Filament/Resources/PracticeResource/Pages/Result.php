<?php

namespace App\Filament\Resources\PracticeResource\Pages;

use App\Filament\Resources\PracticeResource;
use Filament\Resources\Pages\Page;

class Result extends Page
{
    protected static ?string $navigationGroup = 'Result';

    protected static ?string $title = 'Result';

    protected static ?string $navigationLabel = 'Result';

    protected static string $resource = PracticeResource::class;

    protected static string $view = 'filament.resources.practice-resource.pages.result';
}
