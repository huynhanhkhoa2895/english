<?php

namespace App\Filament\Resources\ListeningResource\Pages;

use App\Filament\Resources\ListeningResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListListenings extends ListRecords
{
    protected static string $resource = ListeningResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
