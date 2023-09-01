<?php

namespace App\Filament\Resources\WorksheetResource\Pages;

use App\Filament\Resources\WorksheetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorksheet extends EditRecord
{
    protected static string $resource = WorksheetResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeUpdate(array $data): array
    {
        if( ! isset($data['creator_id']))
            $data['creator_id'] = auth()->user()->id;

        return $data;
    }
}
