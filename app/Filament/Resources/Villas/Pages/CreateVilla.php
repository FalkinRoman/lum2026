<?php

namespace App\Filament\Resources\Villas\Pages;

use App\Filament\Resources\Villas\Concerns\NormalizesVillaMedia;
use App\Filament\Resources\Villas\VillaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVilla extends CreateRecord
{
    use NormalizesVillaMedia;

    protected static string $resource = VillaResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->normalizeVillaMedia($data);
    }
}
