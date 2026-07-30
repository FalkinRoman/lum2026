<?php

namespace App\Filament\Resources\PageSections\Pages;

use App\Filament\Resources\PageSections\StaySectionResource;
use App\Filament\Resources\PageSections\Concerns\HandlesPageSectionForm;
use Filament\Resources\Pages\EditRecord;

class EditStaySection extends EditRecord
{
    use HandlesPageSectionForm;

    protected static string $resource = StaySectionResource::class;
}
