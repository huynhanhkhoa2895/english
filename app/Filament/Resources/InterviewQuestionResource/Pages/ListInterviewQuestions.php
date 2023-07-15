<?php

namespace App\Filament\Resources\InterviewQuestionResource\Pages;

use App\Filament\Resources\InterviewQuestionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInterviewQuestions extends ListRecords
{
    protected static string $resource = InterviewQuestionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
