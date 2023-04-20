<?php

namespace App\Filament\Resources\PracticeResource\RelationManagers;

use App\Interface\VocabularyInterface;
use App\Models\Practice;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\Select;
use Filament\Tables\Contracts\HasRelationshipTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Select::make('position')
                    ->required()
                    ->default("developer")
                ->options([
                    "developer"=> "Developer",
                    "leader"=> "Leader"
                ]),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->getStateUsing( function (Model $record,HasRelationshipTable $livewire){
                        return $livewire->ownerRecord->students()->firstWhere("student_id",$record->id)->pivot->due_date;
                    }),
                Tables\Columns\TextColumn::make('point')
                    ->getStateUsing( function (Model $record,HasRelationshipTable $livewire){
                        return $livewire->ownerRecord->students()->firstWhere("student_id",$record->id)->pivot->point;
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
//                Tables\Actions\AttachAction::make(),
                Tables\Actions\Action::make("attach")
                    ->label("Attach")
                    ->action(function (array $data,HasRelationshipTable $livewire): void {
                        $livewire->ownerRecord->students()->sync([
                            [
                                "student_id" => $data["student_id"],
                                "due_date" => $data["due_date"],
                            ]
                        ]);
                    })
                    ->form([
                        Select::make('student_id')
                        ->options(Student::all()->pluck('name', 'id'))
                        ->searchable(),
                        Forms\Components\DatePicker::make('due_date'),
                    ])
                    ->color('success'),
            ])
            ->actions([
                Tables\Actions\Action::make("view")->label("PracticeStudentResult")->modalContent(fn (Model $record) => view("filament.pages.actions.viewResult",["record"=>$record])),
                Tables\Actions\DetachAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }
}
