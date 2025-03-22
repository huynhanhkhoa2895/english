<?php

namespace App\Filament\Resources\ListeningResource\Pages;

use App\Filament\Resources\ListeningResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditListening extends EditRecord
{
    protected static string $resource = ListeningResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
