<?php

namespace App\Filament\Resources\VocabularyResource\Pages;

use App\Filament\Resources\VocabularyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVocabulary extends EditRecord
{
    protected static string $resource = VocabularyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
