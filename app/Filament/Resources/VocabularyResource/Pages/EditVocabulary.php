<?php

namespace App\Filament\Resources\VocabularyResource\Pages;

use App\Filament\Resources\VocabularyResource;
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
        dd($this->record->id);
//        $this->redirect($resources::getUrl('create'));
//        $this->save(true);
    }
}
