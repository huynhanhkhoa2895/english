<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use App\Filament\Resources\PracticeResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

class PracticesRelationManager extends RelationManager
{
    protected static string $relationship = 'practices';

    protected static ?string $recordTitleAttribute = 'name';
    /**
     * @var Forms\ComponentContainer|\Illuminate\Contracts\View\View|mixed|null
     */

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make("view")->action(function (Model $record): mixed {
                    $resource = PracticeResource::class;
                    return redirect($resource::getUrl('edit',[$record->id]));
                }),
                Tables\Actions\DetachAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }
}
