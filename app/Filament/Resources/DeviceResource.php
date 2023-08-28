<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceResource\Pages;
use App\Filament\Resources\DeviceResource\RelationManagers;
use App\Models\Device;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Toggle;

class DeviceResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): string
    {
        return __('module_names.navigation_groups.administration');
    }

    public static function getModelLabel(): string
    {
        return __('module_names.devices.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('module_names.devices.plural_label');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DocumentsRelationManager::class,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nev')->label(__('fields.nev'))
                    ->required()
                    ->unique()
                    ->maxLength(255),
                Forms\Components\TextInput::make('bpkod')->label(__('fields.bpkod'))
                    ->required()
                    ->unique()
                    ->maxLength(255),
                Forms\Components\Select::make('type_id')->label(__('fields.type'))
                    ->relationship('type', 'nev')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nev')->label(__('fields.nev'))
                            ->required()
                            ->maxLength(255)
                    ])
                    ->required(),
                Forms\Components\TextInput::make('movexkod')->label(__('fields.movexkod'))
                    ->unique()
                    ->maxLength(255),
                Forms\Components\TextInput::make('uzem')->label(__('fields.uzem'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('uzemterulet')->label(__('fields.uzemterulet'))
                    ->maxLength(255),
                Toggle::make('aktiv')->label(__('fields.aktiv'))
                    ->onColor('success')
                    ->offColor('danger')
                    ->columnSpan('full'),
                Forms\Components\TextInput::make('tortenet')->label(__('fields.tortenet'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('megjegyzes')->label(__('fields.megjegyzes'))
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('nev')->label(__('fields.nev'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('bpkod')->label(__('fields.bpkod'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type.nev')->label(__('fields.type'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('fields.created_at'))
                    ->dateTime('Y. m. d. H:i')
                    ->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDevices::route('/'),
            'create' => Pages\CreateDevice::route('/create'),
            'edit' => Pages\EditDevice::route('/{record}/edit'),
            'view' => Pages\ViewDevice::route('/{record}'),
        ];
    }
}
