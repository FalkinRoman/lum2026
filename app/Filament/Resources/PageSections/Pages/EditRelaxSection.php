<?php

namespace App\Filament\Resources\PageSections\Pages;

use App\Filament\Resources\PageSections\RelaxSectionResource;
use App\Filament\Resources\PageSections\Concerns\HandlesPageSectionForm;
use Filament\Resources\Pages\EditRecord;

class EditRelaxSection extends EditRecord
{
    use HandlesPageSectionForm;

    protected static string $resource = RelaxSectionResource::class;
}
