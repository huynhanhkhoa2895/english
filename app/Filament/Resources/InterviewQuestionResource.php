<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InterviewQuestionResource\Pages;
use App\Filament\Resources\InterviewQuestionResource\RelationManagers;
use App\Models\InterviewQuestion;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class InterviewQuestionResource extends Resource
{
    protected static ?string $model = InterviewQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                MarkdownEditor::make('question')->columnSpanFull()->required(),
                TinyEditor::make('answer')
                    ->required()
                    ->columnSpanFull()
                    ->required(),
                Select::make('tags')
                    ->options([
                        'html' => 'HTML',
                        'react' => 'React',
                        'javascript' => 'Javascript',
                        'css' => 'CSS',
                        'laravel' => 'Laravel',
                    ])
                    ->multiple(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')->sortable(),
                TextColumn::make('tags'),
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
            RelationManagers\LessonsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInterviewQuestions::route('/'),
            'create' => Pages\CreateInterviewQuestion::route('/create'),
            'edit' => Pages\EditInterviewQuestion::route('/{record}/edit'),
        ];
    }
}
