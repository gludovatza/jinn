<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Filament\Resources\DocumentResource\RelationManagers;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): string
    {
        return __('module_names.navigation_groups.administration');
    }

    public static function getModelLabel(): string
    {
        return __('module_names.documents.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('module_names.documents.plural_label');
    }

    public static function form(Form $form): Form
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
                FileUpload::make('attachment')
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('nev')->label(__('fields.nev'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('device.nev')->label(__('module_names.devices.label'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('fields.created_at'))
                    ->dateTime('Y. m. d. H:i')
                    ->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\Action::make('exportAsJson')
                //     ->label(__('Export'))
                //     ->action(function ($record) {
                //         $name = $record->name;
                //         return response()->streamDownload(function () use ($record) {
                //             $return = $record->attributesToArray();
                //             echo json_encode($return, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
                //         }, $name . '.json');
                //     })
                //     ->tooltip(__('Export'))
                //     ->icon('heroicon-o-document-arrow-down')
                //     ->color('primary'),
                Tables\Actions\Action::make('download')
                    ->label(__('actions.download'))
                    ->action(function ($record) {
                        return Storage::download('public/'. $record->attachment);
                    })
                    ->tooltip(__('actions.download'))
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('primary'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
