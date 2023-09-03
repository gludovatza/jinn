<?php

namespace App\Filament\Resources\DeviceResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DocumentResource;
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

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nev')
            ->columns([
                Tables\Columns\TextColumn::make('nev')->label(__('fields.nev')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->url(fn (): string => DocumentResource::getUrl('create')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->url(fn (Model $record): string => DocumentResource::getUrl('edit', ['record' => $record])),
                Tables\Actions\Action::make('download')
                    ->label(__('actions.download'))
                    ->action(function ($record) {
                        return Storage::download('public/' . $record->attachment);
                    })
                    ->tooltip(__('actions.download'))
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('primary'),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->url(fn (): string => DocumentResource::getUrl('create')),
            ]);
    }
}
