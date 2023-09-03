<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Worksheet;
use Filament\Tables\Table;
use App\Enums\WorksheetPriority;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\WorksheetResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\WorksheetResource\RelationManagers;

class WorksheetResource extends Resource
{
    protected static ?string $model = Worksheet::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-plus';

    public static function getNavigationGroup(): string
    {
        return __('module_names.navigation_groups.failure_report');
    }

    protected static ?int $navigationSort = 7;

    public static function getModelLabel(): string
    {
        return __('module_names.worksheets.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('module_names.worksheets.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\Select::make('device_id')->label(__('module_names.devices.label'))
                            ->relationship('device', 'nev')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('creator_id')->label(__('fields.creator'))
                            ->relationship('creator', 'name')
                            ->required()
                            //->disabledOn('edit')
                            ->default(auth()->user()->hasRole('admin') ? null : auth()->user()->id)
                            ->disabled(auth()->user()->hasRole('admin') ? false : true),
                        Forms\Components\Select::make('repairer_id')->label(__('fields.repairer'))
                            ->options(User::role('karbantartó')->get()->pluck('name', 'id')),
                        Forms\Components\Select::make('priority')->label(__('fields.priority'))
                            // ->options(['Normál' => 'Normál', 'Sürgős' => 'Sürgős', 'Leálláskor' => 'Leálláskor'])
                            ->options(WorksheetPriority::class)
                            ->default('Normál')
                            ->required(),
                        Forms\Components\Textarea::make('description')->label(__('fields.description'))
                            ->required()
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\DatePicker::make('due_date')->label(__('fields.due_date'))
                            ->minDate(now()),
                        Forms\Components\DatePicker::make('finish_date')->label(__('fields.finish_date'))
                            ->minDate(now()),
                        FileUpload::make('attachments')->label(__('fields.attachments'))
                            ->multiple()
                            ->required()
                            ->preserveFilenames()
                            ->openable()
                            ->downloadable()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('comment')->label(__('fields.megjegyzes'))
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('device.nev')->label(__('module_names.devices.label'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('description')->label(__('fields.description'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('creator.name')->label(__('fields.creator'))
                    ->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('repairer.name')->label(__('fields.repairer'))
                    ->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('priority')->badge()->label(__('fields.priority'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('due_date')->label(__('fields.due_date'))
                    ->dateTime('Y-m-d H:i')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('finish_date')->label(__('fields.finish_date'))
                    ->dateTime('Y-m-d H:i')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('fields.created_at'))
                    ->dateTime('Y-m-d H:i')
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('device')->label(__('module_names.devices.label'))
                    ->relationship('device', 'nev'),
                Tables\Filters\SelectFilter::make('priority')->label(__('fields.priority'))
                    ->options(WorksheetPriority::class),

            ])
            ->actions([
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorksheets::route('/'),
            'create' => Pages\CreateWorksheet::route('/create'),
            'edit' => Pages\EditWorksheet::route('/{record}/edit'),
            'view' => Pages\ViewWorksheet::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (!auth()->user()->hasRole('admin')) {
            return parent::getEloquentQuery()
                ->where('creator_id', auth()->user()->id)
                ->orWhere('repairer_id', auth()->user()->id);
        }
        return parent::getEloquentQuery();
    }
}
