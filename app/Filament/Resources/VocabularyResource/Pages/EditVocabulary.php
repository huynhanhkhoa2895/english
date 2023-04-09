<?php

namespace App\Filament\Resources\VocabularyResource\Pages;

use App\Filament\Resources\VocabularyResource;
use App\Interface\VocabularyInterface;
use Filament\Pages\Actions;
use Filament\Pages\Action;
use Filament\Resources\Pages\EditRecord;


class EditVocabulary extends EditRecord
{
    protected static string $resource = VocabularyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('goToPrevious')
                ->label('Previous Vocabulary')
                ->action('goToPrevious')
                ->color('success'),
            Actions\Action::make('goToNext')
                ->label('Next Vocabulary')
                ->action('goToNext')
                ->color('success'),

            $this->getCancelFormAction(),
        ];
    }

    public function goToNext()
    {
        $resources = static::getResource();
        $vocabularyService = app(VocabularyInterface::class);
        $data = $vocabularyService->getNextPreviousVocabulary($this->record,"next");
        if(!empty($data)){
            $this->redirect($resources::getUrl('edit',[$data->id]));
        }
    }

    public function goToPrevious()
    {
        $resources = static::getResource();
        $vocabularyService = app(VocabularyInterface::class);
        $data = $vocabularyService->getNextPreviousVocabulary($this->record,"previous");
        if(!empty($data)){
            $this->redirect($resources::getUrl('edit',[$data->id]));
        }
    }
}
