<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PracticeResource\Pages;
use App\Filament\Resources\PracticeResource\RelationManagers;
use App\Models\Practice;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
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

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Practice';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('level')
                    ->options([
                        'A1' => 'A1',
                        'A2' => 'A2',
                        'B1' => 'B1',
                        'B2' => 'B2',
                        'C1' => 'C1',
                        'C2' => 'C2',
                    ])->required()->default('a1'),
                Select::make('type')
                    ->options([
                        'reading' => 'Reading',
                        'listening' => 'Listening',
                        'vocabulary' => 'Vocabulary',
                    ])->required()->default('a1'),
                TextInput::make('instructions')->maxLength(255),
                TinyEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('media')
                    ->acceptedFileTypes(['audio/*','image/*'])
                    ->getUploadedFileNameForStorageUsing(function (Practice $record,TemporaryUploadedFile $file): string {
                        $array = explode(".", $file->getClientOriginalName());
                        return Str::slug($record->name).".".end($array);
                    }),
                TextInput::make('link_video')->maxLength(255),
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
                                'multiple_choice' => 'Multiple Choice',
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
                                    ->required()
                                    ->maxLength(255),
                                Repeater::make('values')
                                    ->schema([
                                        TextInput::make('label'),
                                        TextInput::make('value'),
                                    ])
                                    ->columns(2)
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
            'result' => Pages\Result::route('/result'),
        ];
    }
}
