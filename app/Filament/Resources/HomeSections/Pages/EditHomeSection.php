<?php

namespace App\Filament\Resources\HomeSections\Pages;

use App\Filament\Forms\HomeSectionImages;
use App\Filament\Resources\HomeSections\HomeSectionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHomeSection extends EditRecord
{
    protected static string $resource = HomeSectionResource::class;

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
        $payload = is_array($data['payload'] ?? null) ? $data['payload'] : [];
        $key = (string) ($data['key'] ?? '');
        $data['images'] = HomeSectionImages::extract($key, $payload);

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $payload = is_array($data['payload'] ?? null) ? $data['payload'] : [];
        $images = is_array($data['images'] ?? null) ? $data['images'] : [];
        $key = (string) ($data['key'] ?? $this->record->key ?? '');

        $data['payload'] = HomeSectionImages::merge($key, $payload, $images);
        unset($data['images']);

        return $data;
    }
}
