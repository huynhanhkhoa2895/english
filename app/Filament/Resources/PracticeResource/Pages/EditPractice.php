<?php

namespace App\Filament\Resources\PracticeResource\Pages;

use App\Filament\Resources\PracticeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPractice extends EditRecord
{
    protected static string $resource = PracticeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
