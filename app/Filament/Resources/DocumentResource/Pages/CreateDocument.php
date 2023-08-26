<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
// use Illuminate\Support\Facades\Storage;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $data['type'] = Storage::mimeType($data['attachment']);

    //     return $data;
    // }
}
