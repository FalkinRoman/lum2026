<?php

namespace App\Filament\Resources\PageSections\Pages;

use App\Filament\Resources\PageSections\DiningSectionResource;
use App\Filament\Resources\PageSections\Concerns\HandlesPageSectionForm;
use Filament\Resources\Pages\EditRecord;

class EditDiningSection extends EditRecord
{
    use HandlesPageSectionForm;

    protected static string $resource = DiningSectionResource::class;
}
