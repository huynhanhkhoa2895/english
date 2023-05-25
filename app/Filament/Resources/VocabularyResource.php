<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VocabularyResource\Pages;
use App\Filament\Resources\VocabularyResource\RelationManagers;
use App\Interface\VocabularyInterface;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Vocabulary;
use App\Rules\VocabularyUnique;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Livewire\TemporaryUploadedFile;
use Closure;

class VocabularyResource extends Resource
{
    protected static ?string $model = Vocabulary::class;

    protected static ?string $navigationIcon = 'heroicon-o-server';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('vocabulary')
                    ->rules([
                        function(Closure $get) {
                            return new VocabularyUnique([
                                "vocabulary" => $get('vocabulary'),
                                "parts_of_speech" => $get('parts_of_speech')
                            ]);
                        }
                    ])
                    ->required(),
                TextInput::make('translate'),
                TextInput::make('spelling')->label('Transcript'),
                Forms\Components\Select::make('category_id')
                    ->relationship('categories', 'name'),
                Select::make('parts_of_speech')
                    ->options([
                        'n' => 'Noun (n)',
                        'v' => 'Verb (v)',
                        'adj' => 'Adjective (adj)',
                        'adv' => 'Adverb (adv)',
                    ])
                    ->rules([
                        function(Closure $get) {
                            return new VocabularyUnique([
                                "vocabulary" => $get('vocabulary'),
                                "parts_of_speech" => $get('parts_of_speech')
                            ]);
                        }
                    ])
                    ->required(),
                MarkdownEditor::make('definition')->columnSpanFull(),
                MarkdownEditor::make('example')->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('image')
                    ->acceptedFileTypes(['image/*'])
                    ->getUploadedFileNameForStorageUsing(function (Vocabulary $record,TemporaryUploadedFile $file): string {
                        $array = explode(".", $file->getClientOriginalName());
                        return $record->vocabulary.".".end($array);
                    })
                    ->image(),
                FileUpload::make('sound')
                    ->disk('speech')
                    ->visibility('public')
                    ->acceptedFileTypes(['audio/mpeg'])
                    ->maxSize(100)
                    ->getUploadedFileNameForStorageUsing(function (Closure $get): string {
                        return  $get('vocabulary').".mp3";
                    })
                    ->enableDownload()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vocabulary')->sortable()->searchable(),
                TextColumn::make('parts_of_speech')->sortable(),
                TextColumn::make('transcript')->label('Transcript'),
                TextColumn::make('categories.name')->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
                TextColumn::make('updated_at')->dateTime()->sortable()
            ])
            ->filters([
                SelectFilter::make('parts_of_speech')
                    ->options([
                        'n' => 'Noun (n)',
                        'v' => 'Verb (v)',
                        'adj' => 'Adjective (adj)',
                        'adv' => 'Adverb (adv)',
                    ]),
                SelectFilter::make('student')
                    ->relationship("students","name"),
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_at'),
                    ])->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['created_at'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '=', $date),
                        );
                    })
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
                BulkAction::make('attachStudent')
                    ->action(function (Collection $records, array $data): void {
                        foreach ($records as $record) {
                            $record->students()->syncWithoutDetaching($data['studentId']);
                        }
                    })
                    ->form([
                        Forms\Components\Select::make('studentId')
                            ->label('Student')
                            ->options(Student::query()->pluck('name', 'id'))
                            ->required(),
                    ]),
                BulkAction::make('exportExcel')
                    ->action(function (Collection $records, array $data) {
                        $vocabularyService = app(VocabularyInterface::class);
                        return $vocabularyService->exportExcel($records,$data['fields']);
                    })
                    ->form([
                        Select::make('fields')
                            ->multiple()
                            ->options([
                                'vocabulary' => 'Vocabulary',
                                'translate' => 'Translate',
                                'spelling' => 'Transcript',
                                'example' => 'Example',
                                'definition' => 'Definition',
                            ])
                        ->required()
                        ->default(['vocabulary','translate','example'])
                    ])

            ])
            ->defaultSort('id','desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\StudentsRelationManager::class
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
