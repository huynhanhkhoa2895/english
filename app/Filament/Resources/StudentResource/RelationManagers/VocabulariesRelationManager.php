<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use App\Filament\Resources\VocabularyResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Contracts\HasRelationshipTable;

class VocabulariesRelationManager extends RelationManager
{
    protected static string $relationship = 'vocabularies';

    protected static ?string $recordTitleAttribute = 'vocabulary';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('vocabulary')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vocabulary'),
                Tables\Columns\TextColumn::make('point')
                    ->getStateUsing( function (Model $record,HasRelationshipTable $livewire){
                        return $record->students->firstWhere("id",$livewire->ownerRecord->id)->pivot->point;
                    }),
                Tables\Columns\TextColumn::make('repeat')
                    ->getStateUsing( function (Model $record,HasRelationshipTable $livewire){
                        return $record->students->firstWhere("id",$livewire->ownerRecord->id)->pivot->repeat;
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make("view")->action(function (Model $record): mixed {
                    $resource = VocabularyResource::class;
                    return redirect($resource::getUrl('edit',[$record->id]));
                }),
                Tables\Actions\DetachAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }
}
