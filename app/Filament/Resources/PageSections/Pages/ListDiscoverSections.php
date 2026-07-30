<?php

namespace App\Filament\Resources\PageSections\Pages;

use App\Filament\Resources\PageSections\DiscoverSectionResource;
use Filament\Resources\Pages\ListRecords;

class ListDiscoverSections extends ListRecords
{
    protected static string $resource = DiscoverSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
