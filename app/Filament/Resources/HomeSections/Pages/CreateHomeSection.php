<?php

namespace App\Filament\Resources\HomeSections\Pages;

use App\Filament\Forms\HomeSectionImages;
use App\Filament\Resources\HomeSections\HomeSectionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHomeSection extends CreateRecord
{
    protected static string $resource = HomeSectionResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $payload = is_array($data['payload'] ?? null) ? $data['payload'] : ['en' => [], 'ru' => []];
        $images = is_array($data['images'] ?? null) ? $data['images'] : [];
        $key = (string) ($data['key'] ?? '');

        $data['payload'] = HomeSectionImages::merge($key, $payload, $images);
        unset($data['images']);

        return $data;
    }
}
