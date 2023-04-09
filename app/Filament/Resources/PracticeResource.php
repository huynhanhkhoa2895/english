<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PracticeResource\Pages;
use App\Filament\Resources\PracticeResource\RelationManagers;
use App\Models\Practice;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Livewire\TemporaryUploadedFile;
use Str;

class PracticeResource extends Resource
{
    protected static ?string $model = Practice::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('level')
                    ->options([
                        'a1' => 'A1',
                        'a2' => 'A2',
                        'b1' => 'B1',
                        'b2' => 'B2',
                        'c1' => 'C1',
                        'c2' => 'C2',
                    ])->required()->default('a1'),
                Select::make('type')
                    ->options([
                        'reading' => 'Reading',
                        'listening' => 'Listening',
                    ])->required()->default('a1'),
                TextInput::make('instructions')->maxLength(255),
                MarkdownEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('media')
                    ->acceptedFileTypes(['video/*','audio/*','image/*'])
                    ->columnSpanFull()
                    ->getUploadedFileNameForStorageUsing(function (Practice $record,TemporaryUploadedFile $file): string {
                        $array = explode(".", $file->getClientOriginalName());
                        return Str::slug($record->name).".".end($array);
                    }),
                Repeater::make('questions')
                    ->relationship()
                    ->columnSpanFull()
                    ->required()
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Select::make('type')
                            ->options([
                                'true_false' => 'True/False',
                                'fill_in' => 'Fill in',
                            ])->required()->default('true_false'),
                        MarkdownEditor::make('description')
                            ->required(),
                        Repeater::make('contents')
                            ->columnSpanFull()
                            ->relationship()
                            ->collapsed()
                            ->schema([
                                TextInput::make('question')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('answer')
                                    ->maxLength(255),
                        ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('level'),
                TextColumn::make('type'),
                TextColumn::make('created_at')
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\StudentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPractices::route('/'),
            'create' => Pages\CreatePractice::route('/create'),
            'edit' => Pages\EditPractice::route('/{record}/edit'),
        ];
    }
}
