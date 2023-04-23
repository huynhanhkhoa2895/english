<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use App\Filament\Resources\PracticeResource;
use App\Models\Practice;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Contracts\HasRelationshipTable;
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
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->getStateUsing( function (Model $record,HasRelationshipTable $livewire){
                        return $livewire->ownerRecord->practices()->firstWhere("practice_id",$record->id)->pivot->due_date;
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make("attach")
                    ->label("Attach")
                    ->action(function (array $data,HasRelationshipTable $livewire): void {
                        $livewire->ownerRecord->practices()->sync([
                            [
                                "practice_id" => $data["practice_id"],
                                "due_date" => $data["due_date"],
                            ]
                        ]);
                    })
                    ->form([
                        Select::make('practice_id')
                            ->label('Practice')
                            ->required()
                            ->options(Practice::all()->pluck('name', 'id'))
                            ->searchable(),
                        Forms\Components\DatePicker::make('due_date'),
                    ])
                    ->color('success'),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }
}
