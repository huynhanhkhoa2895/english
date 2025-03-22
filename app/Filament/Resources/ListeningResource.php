<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ListeningResource\Pages;
use App\Filament\Resources\ListeningResource\RelationManagers;
use App\Models\Listening;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ListeningResource extends Resource
{
    protected static ?string $model = Listening::class;

    protected static ?string $navigationIcon = 'heroicon-o-device-mobile';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                MarkdownEditor::make('script')->columnSpanFull(),
                FileUpload::make('sound')
                    ->disk('listening')
                    ->visibility('public')
                    ->acceptedFileTypes(['audio/mpeg'])
                    ->maxSize(1000000)
                    ->getUploadedFileNameForStorageUsing(function (Closure $get): string {
                        return  $get('name')."_".now().".mp3";
                    })
                    ->enableDownload()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
                TextColumn::make('updated_at')->dateTime()->sortable()
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
            'index' => Pages\ListListenings::route('/'),
            'create' => Pages\CreateListening::route('/create'),
            'edit' => Pages\EditListening::route('/{record}/edit'),
        ];
    }
}
