<?php

namespace App\Filament\Resources\HomeSections\Pages;

use App\Filament\Forms\HomeSectionState;
use App\Filament\Resources\HomeSections\HomeSectionResource;
use App\Filament\Resources\HomeSections\Schemas\Sections\BlogForm;
use Filament\Resources\Pages\EditRecord;

class EditHomeSection extends EditRecord
{
    protected static string $resource = HomeSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTitle(): string
    {
        $key = (string) ($this->record->key ?? '');

        return \App\Models\HomeSection::LABELS[$key] ?? parent::getTitle();
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $key = (string) ($data['key'] ?? $this->record->key ?? '');

        return HomeSectionState::fill($key, $data);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $key = (string) ($data['key'] ?? $this->record->key ?? '');

        if ($key === 'blog') {
            BlogForm::assertUniquePosts($data);
        }

        return HomeSectionState::save($key, $data);
    }
}
