<?php

namespace App\Filament\Resources\DeviceResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    public static function getModelLabel(): string
    {
        return __('module_names.documents.label');
    }
    protected static ?string $title = 'Dokumentumok';

    // public static function getTitle(Model $ownerRecord, string $pageClass): string
    // {
    //     return __('module_names.documents.plural_label');
    // }

    // public static function getTitle(Model $ownerRecord, string $pageClass): string
    // {
    //     return 'asdf';
    // }
    public static function getPluralModelLabel(): string
    {
        return __('module_names.documents.plural_label');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nev')->label(__('fields.nev'))
                    ->required()
                    ->unique()
                    ->maxLength(255),
                Forms\Components\Select::make('device_id')->label(__('module_names.devices.label'))
                    ->relationship('device', 'nev')
                    ->searchable()
                    ->preload()

                    ->required(),
                FileUpload::make('attachment')->label(__('fields.attachment'))
                    ->required()
                    ->preserveFilenames()
                    ->openable()
                    ->downloadable()
                    ->maxSize(20000),
                // ->afterStateUpdated(fn (callable $set, callable $get) => $set('type', $get('video')->getMimeType())),

                // Forms\Components\TextInput::make('type')
                //     ->maxLength(25),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nev')
            ->columns([
                Tables\Columns\TextColumn::make('nev'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
