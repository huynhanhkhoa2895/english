<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VocabularyResource\Pages;
use App\Filament\Resources\VocabularyResource\RelationManagers;
use App\Models\Vocabulary;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;

class VocabularyResource extends Resource
{
    protected static ?string $model = Vocabulary::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('vocabulary')->unique(ignoreRecord: true)->required(),
                TextInput::make('translate'),
                TextInput::make('spelling'),
                Forms\Components\Select::make('category_id')
                    ->relationship('categories', 'name'),
                RichEditor::make('example')->columnSpanFull(),
                FileUpload::make('sound')
                    ->disk('speech')
                    ->visibility('public')
                    ->acceptedFileTypes(['audio/mpeg'])
                    ->maxSize(100)
                    ->enableDownload()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vocabulary')->sortable()->searchable(),
                TextColumn::make('translate')->sortable(),
                TextColumn::make('spelling')->sortable(),
                TextColumn::make('categories.name')->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('vocabulary');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVocabularies::route('/'),
            'create' => Pages\CreateVocabulary::route('/create'),
            'edit' => Pages\EditVocabulary::route('/{record}/edit'),
        ];
    }
}
