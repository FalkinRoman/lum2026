<?php

namespace App\Filament\Resources\Villas\Pages;

use App\Filament\Resources\Villas\Concerns\NormalizesVillaMedia;
use App\Filament\Resources\Villas\VillaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVilla extends EditRecord
{
    use NormalizesVillaMedia;

    protected static string $resource = VillaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->normalizeVillaMedia($data);
    }
}
