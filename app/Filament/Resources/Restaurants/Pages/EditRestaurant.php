<?php

namespace App\Filament\Resources\Restaurants\Pages;

use App\Filament\Resources\Restaurants\RestaurantResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRestaurant extends EditRecord
{
    protected static string $resource = RestaurantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterFill(): void
    {
        $this->js(<<<'JS'
            (() => {
                if (window.location.hash !== '#menu') {
                    return;
                }

                const scrollToMenu = () => {
                    const el = document.querySelector('[data-restaurant-menu-rm]')
                        || document.querySelector('.fi-resource-relation-manager');

                    if (! el) {
                        return false;
                    }

                    el.scrollIntoView({ behavior: 'smooth', block: 'start' });

                    return true;
                };

                requestAnimationFrame(() => {
                    if (! scrollToMenu()) {
                        setTimeout(scrollToMenu, 200);
                        setTimeout(scrollToMenu, 600);
                    }
                });
            })();
        JS);
    }
}
