<?php

namespace App\Filament\Resources\DeviceResource\Pages;

use App\Filament\Resources\DeviceResource;
use App\Models\Device;
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
            'active' => Tab::make()->label(__('fields.aktiv'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('aktiv', true))
                ->badge(Device::query()->where('aktiv', true)->count()),
            'all' => Tab::make()->label(__('fields.all'))
                ->badge(Device::query()->count()),
            'inactive' => Tab::make()->label(__('fields.inaktiv'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('aktiv', false))
                ->badge(Device::query()->where('aktiv', false)->count()),
        ];
    }
}
