<?php

namespace App\Filament\Resources\Villas\Pages;

use App\Filament\Resources\Villas\VillaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVilla extends EditRecord
{
    protected static string $resource = VillaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
