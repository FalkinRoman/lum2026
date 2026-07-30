<?php

namespace App\Filament\Resources\PageSections\Pages;

use App\Filament\Resources\PageSections\StaySectionResource;
use Filament\Resources\Pages\ListRecords;

class ListStaySections extends ListRecords
{
    protected static string $resource = StaySectionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
