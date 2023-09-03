<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\WorksheetResource;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class WorksheetsRelationManager extends RelationManager
{
    protected static string $relationship = 'worksheets';

    public static function getModelLabel(): string
    {
        return __('module_names.worksheets.label');
    }
    protected static ?string $title = 'Létrehozott munkalapok';

    public static function getPluralModelLabel(): string
    {
        return __('module_names.worksheets.plural_label');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('device.nev')->label(__('module_names.devices.label'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('description')->label(__('fields.description'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('fields.created_at'))->dateTime('Y-m-d H:i')
                    ->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->url(fn (): string => WorksheetResource::getUrl('create')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->url(fn (Model $record): string => WorksheetResource::getUrl('view', ['record' => $record])),
                Tables\Actions\EditAction::make()->url(fn (Model $record): string => WorksheetResource::getUrl('edit', ['record' => $record])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->url(fn (): string => WorksheetResource::getUrl('create')),
            ]);
    }
}
