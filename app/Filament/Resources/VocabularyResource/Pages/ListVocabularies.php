<?php

namespace App\Filament\Resources\VocabularyResource\Pages;

use App\Filament\Resources\VocabularyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;
use App\Interface\VocabularyInterface;

class ListVocabularies extends ListRecords
{
    protected static string $resource = VocabularyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make("import_excel")
                ->label("Import Excel")
                ->action(function (array $data): void {
                    $vocabularyService = app(VocabularyInterface::class);
                    $vocabularyService->importFromExcel($data['excel']);
                    if(Storage::disk('public')->exists($data['excel'])){
                        Storage::disk('public')->delete($data['excel']);
                    }
                })
                ->form([
                    FileUpload::make('excel')
                        ->visibility('public')
                        ->acceptedFileTypes([
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'text/csv'
                        ])
                        ->required()

                ])
                ->color('success'),
        ];
    }
}
