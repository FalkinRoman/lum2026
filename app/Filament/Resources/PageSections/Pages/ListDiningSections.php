<?php

namespace App\Filament\Resources\PageSections\Pages;

use App\Filament\Resources\PageSections\DiningSectionResource;
use Filament\Resources\Pages\ListRecords;

class ListDiningSections extends ListRecords
{
    protected static string $resource = DiningSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
