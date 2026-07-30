<?php

namespace App\Filament\Resources\PageSections\Concerns;

use App\Filament\Forms\PageSectionState;

trait HandlesPageSectionForm
{
    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTitle(): string
    {
        $page = (string) ($this->record->page ?? '');
        $key = (string) ($this->record->key ?? '');

        return \App\Models\PageSection::labelsFor($page)[$key] ?? parent::getTitle();
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $page = (string) ($data['page'] ?? $this->record->page ?? '');
        $key = (string) ($data['key'] ?? $this->record->key ?? '');

        return PageSectionState::fill($page, $key, $data);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $page = (string) ($data['page'] ?? $this->record->page ?? '');
        $key = (string) ($data['key'] ?? $this->record->key ?? '');
        $data['page'] = $page;

        return PageSectionState::save($page, $key, $data);
    }
}
