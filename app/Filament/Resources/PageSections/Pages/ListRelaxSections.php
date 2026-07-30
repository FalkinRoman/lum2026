<?php

namespace App\Filament\Resources\PageSections\Pages;

use App\Filament\Resources\PageSections\RelaxSectionResource;
use Filament\Resources\Pages\ListRecords;

class ListRelaxSections extends ListRecords
{
    protected static string $resource = RelaxSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
