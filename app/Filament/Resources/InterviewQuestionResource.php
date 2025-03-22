<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InterviewQuestionResource\Pages;
use App\Filament\Resources\InterviewQuestionResource\RelationManagers;
use App\Models\InterviewQuestion;
use App\Models\Lesson;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Collection;
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
                        'hr' => 'HR',
                    ])
                    ->multiple(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')->limit(50),
                TextColumn::make('tags'),
            ])
            ->filters([
                SelectFilter::make('tags')
                    ->options([
                        'html' => 'HTML',
                        'react' => 'React',
                        'javascript' => 'Javascript',
                        'css' => 'CSS',
                        'laravel' => 'Laravel',
                        'hr' => 'HR',
                    ])->multiple(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                BulkAction::make('attachLesson')
                    ->action(function (Collection $records, array $data): void {
                        foreach ($records as $record) {
                            $record->lessons()->syncWithoutDetaching($data['lessonId']);
                        }
                    })
                    ->form([
                        Forms\Components\Select::make('lessonId')
                            ->label('Lesson')
                            ->options(Lesson::query()->pluck('name', 'id'))
                            ->required(),
                    ]),
            ])
            ->defaultSort('id','desc');;
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
