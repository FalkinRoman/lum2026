<?php

namespace App\Filament\Resources\Excursions\Pages;

use App\Filament\Resources\Excursions\ExcursionResource;
use App\Support\ImpressionGalleries;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditExcursion extends EditRecord
{
    protected static string $resource = ExcursionResource::class;

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
    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (ImpressionGalleries::isEmpty($data['impression_galleries'] ?? null)) {
            $data['impression_galleries'] = ImpressionGalleries::forExcursion();
        }

        return $data;
    }
}
