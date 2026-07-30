<?php

namespace App\Filament\Resources\MenuCategories\Pages;

use App\Filament\Resources\MenuCategories\MenuCategoryResource;
use App\Filament\Resources\Restaurants\RestaurantResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditMenuCategory extends EditRecord
{
    protected static string $resource = MenuCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('backToRestaurant')
                ->label('К ресторану')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->url(fn (): ?string => $this->restaurantEditUrl())
                ->visible(fn (): bool => filled($this->record->restaurant_id)),
            DeleteAction::make(),
        ];
    }

    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        $this->record->loadMissing('restaurant');

        $breadcrumbs = [
            RestaurantResource::getUrl('index') => 'Рестораны',
        ];

        $restaurant = $this->record->restaurant;
        if ($restaurant) {
            $breadcrumbs[$this->restaurantEditUrl()] = $restaurant->slug;
        }

        $label = $this->record->getTranslation('label', 'en')
            ?: $this->record->key;

        $breadcrumbs[] = $label;

        return $breadcrumbs;
    }

    public function getTitle(): string | \Illuminate\Contracts\Support\Htmlable
    {
        $label = $this->record->getTranslation('label', app()->getLocale())
            ?: $this->record->getTranslation('label', 'en')
            ?: $this->record->key;

        return 'Позиции: '.$label;
    }

    protected function restaurantEditUrl(): ?string
    {
        $this->record->loadMissing('restaurant');
        $restaurant = $this->record->restaurant;

        if (! $restaurant) {
            return null;
        }

        return RestaurantResource::getUrl('edit', ['record' => $restaurant]).'#menu';
    }

    protected function getRedirectUrl(): string
    {
        return $this->restaurantEditUrl()
            ?? RestaurantResource::getUrl('index');
    }
}
