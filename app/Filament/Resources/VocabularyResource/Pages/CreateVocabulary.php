<?php

namespace App\Filament\Resources\VocabularyResource\Pages;

use App\Filament\Resources\VocabularyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVocabulary extends CreateRecord
{
    protected static string $resource = VocabularyResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();
        $data['vocabulary'] = trim($data['vocabulary']);
        return $data;
    }
}
