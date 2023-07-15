<?php

namespace App\Filament\Resources\InterviewQuestionResource\Pages;

use App\Filament\Resources\InterviewQuestionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInterviewQuestion extends EditRecord
{
    protected static string $resource = InterviewQuestionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
