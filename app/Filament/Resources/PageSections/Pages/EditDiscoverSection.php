<?php

namespace App\Filament\Resources\PageSections\Pages;

use App\Filament\Resources\PageSections\DiscoverSectionResource;
use App\Filament\Resources\PageSections\Concerns\HandlesPageSectionForm;
use Filament\Resources\Pages\EditRecord;

class EditDiscoverSection extends EditRecord
{
    use HandlesPageSectionForm;

    protected static string $resource = DiscoverSectionResource::class;
}
