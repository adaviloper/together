<?php

namespace App\Filament\Resources\ImportMappings\Pages;

use App\Filament\Resources\ImportMappings\ImportMappingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateImportMapping extends CreateRecord
{
    protected static string $resource = ImportMappingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['organization_id'] = session('current_organization_id');

        return $data;
    }
}
