<?php

namespace App\Filament\Resources\MenuCategories\Pages;

use App\Filament\Resources\MenuCategories\MenuCategoryResource;
use App\Filament\Resources\Restaurants\RestaurantResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMenuCategory extends CreateRecord
{
    protected static string $resource = MenuCategoryResource::class;

    public static function canAccess(array $parameters = []): bool
    {
        return false;
    }

    public function mount(): void
    {
        $this->redirect(RestaurantResource::getUrl('index'), navigate: false);
    }
}
