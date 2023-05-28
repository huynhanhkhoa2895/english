<?php

namespace App\Filament\Resources\VocabularyResource\RelationManagers;

use App\Filament\Resources\VocabularyResource;
use App\Interface\VocabularyInterface;
use App\Models\Vocabulary;
use App\Rules\VocabularyUnique;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Closure;
use Illuminate\Database\Eloquent\Model;

class VocabularyRelationshipRelationManager extends RelationManager
{
    protected static string $relationship = 'vocabulary_relationship_main';

    protected static ?string $recordTitleAttribute = 'vocabulary';

    protected static ?string $title = "Vocabulary Relationship";
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('vocabulary')
                    ->rules([
                        function(Closure $get) {
                            return new VocabularyUnique([
                                "id" => $get("id"),
                                "vocabulary" => $get('vocabulary'),
                                "parts_of_speech" => $get('parts_of_speech')
                            ]);
                        }
                    ])
                    ->required(),
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
                                "id" => $get("id"),
                                "vocabulary" => $get('vocabulary'),
                                "parts_of_speech" => $get('parts_of_speech')
                            ]);
                        }
                    ])
                    ->required(),
                TextInput::make('translate'),
                MarkdownEditor::make('definition')->columnSpanFull(),
                MarkdownEditor::make('example')->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('vocabulary_relationship_vocabulary.vocabulary')
                ->label("Vocabulary"),
                Tables\Columns\TextColumn::make('vocabulary_relationship_vocabulary.parts_of_speech')
                ->label("Parts of speech"),
                Tables\Columns\TextColumn::make('vocabulary_relationship_vocabulary.relationship')
                    ->label("Relationship"),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make("attach")
                    ->button()
                    ->label("Attach")
                    ->action(function (array $data,VocabularyInterface $vocabulary,RelationManager $livewire): mixed {
                        return $vocabulary->syncRelationship($livewire->ownerRecord->id,$data['vocabulary'],$data['relationship']);
                    })
                ->form([
                    Forms\Components\Select::make('vocabulary')
                        ->relationship(
                            'vocabulary_relationship_vocabulary',
                            'vocabulary',
                                fn (Builder $query, RelationManager $livewire) => $query->where("id","!=",$livewire->ownerRecord->id)
                        )
                        ->searchable()
                        ->getOptionLabelFromRecordUsing(fn (Vocabulary $record) => "{$record->vocabulary} ({$record->parts_of_speech})")
                        ->required(),
                    Forms\Components\Select::make('relationship')
                        ->options([
                            'word-form' => 'Word-form',
                            'synonyms' => 'Synonyms',
                            'antonyms' => 'Antonyms',
                        ])
                        ->default('word-form')
                ]),
                Tables\Actions\CreateAction::make()->label("New vocabulary"),

            ])
            ->actions([
                Tables\Actions\Action::make("view")->action(function (Model $record): mixed {
                    $resource = VocabularyResource::class;
                    return redirect($resource::getUrl('edit',[$record->vocabulary_relationship]));
                }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
