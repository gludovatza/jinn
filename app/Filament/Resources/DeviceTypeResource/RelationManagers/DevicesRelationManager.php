<?php

namespace App\Filament\Resources\DeviceTypeResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class DevicesRelationManager extends RelationManager
{
    protected static string $relationship = 'devices';

    public static function getModelLabel(): string
    {
        return __('module_names.devices.label');
    }

    protected static ?string $title = 'Berendezések';

    public static function getPluralModelLabel(): string
    {
        return __('module_names.devices.plural_label');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
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
                    ])
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
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('QR')->label('QR kód')
                    ->modalContent(fn ($record): View => view('filament.resources.device-resource.pages.q-r-device', ['record' => $record]))
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
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
