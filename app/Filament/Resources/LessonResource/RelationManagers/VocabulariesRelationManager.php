<?php

namespace App\Filament\Resources\LessonResource\RelationManagers;

use App\Interface\LessonInterface;
use App\Interface\VocabularyInterface;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\DatePicker;
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
                TextInput::make('translate'),
                TextInput::make('spelling'),
                Forms\Components\Select::make('category_id')
                    ->relationship('categories', 'name'),
                RichEditor::make('example')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vocabulary'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make(),
                Tables\Actions\Action::make("import_excel")
                    ->button()
                    ->label("Import Vocabulary with Date")
                    ->action(function (HasRelationshipTable $livewire,array $data): void {
                        $lessonService = app(LessonInterface::class);
                        $lessonService->attachVocabulary("date",$data['date'],$livewire->getRelationship()->getParent());
                    })
                    ->form([
                        DatePicker::make('date')->required()
                    ])
                    ->color('success')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('vocabulary');
    }
}
