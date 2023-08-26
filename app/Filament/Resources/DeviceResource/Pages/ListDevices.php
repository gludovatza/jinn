<?php

namespace App\Filament\Resources\DeviceResource\Pages;

use App\Filament\Resources\DeviceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListDevices extends ListRecords
{
    protected static string $resource = DeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()->label(__('fields.all')),
            'active' => Tab::make()->label(__('fields.aktiv'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('aktiv', true)),
            'inactive' => Tab::make()->label(__('fields.inaktiv'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('aktiv', false)),
        ];
    }
}
