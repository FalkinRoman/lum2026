<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Activities\ActivityResource;
use App\Filament\Resources\BlogPosts\BlogPostResource;
use App\Filament\Resources\Restaurants\RestaurantResource;
use App\Filament\Resources\ShopProducts\ShopProductResource;
use App\Filament\Resources\Villas\VillaResource;
use App\Models\Activity;
use App\Models\BlogPost;
use App\Models\Excursion;
use App\Models\Restaurant;
use App\Models\ShopProduct;
use App\Models\Villa;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CmsStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = -2;

    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $villasPublished = Villa::query()->published()->count();
        $villasTotal = Villa::query()->count();

        $restaurantsTotal = Restaurant::query()->count();
        $restaurantsSoon = Restaurant::query()->where('opening_soon', true)->count();

        $activities = Activity::query()->published()->count();
        $excursions = Excursion::query()->published()->count();

        $blogPublished = BlogPost::query()->published()->count();
        $blogDrafts = BlogPost::query()->where('is_published', false)->count();

        $shopPublished = ShopProduct::query()->published()->count();

        $villasWithoutExely = Villa::query()
            ->where(function ($query): void {
                $query->whereNull('exely_hotel_id')
                    ->orWhere('exely_hotel_id', '');
            })
            ->count();

        $blogDescription = $blogDrafts > 0
            ? "{$blogDrafts} ".trans_choice('черновик|черновика|черновиков', $blogDrafts)
            : 'опубликовано';

        $exelyStat = Stat::make('Без Exely', (string) $villasWithoutExely)
            ->description($villasWithoutExely > 0 ? 'виллы без hotel ID' : 'все подключены')
            ->icon(Heroicon::OutlinedLink)
            ->url(VillaResource::getUrl('index'));

        if ($villasWithoutExely > 0) {
            $exelyStat->color('warning')->descriptionColor('warning');
        } else {
            $exelyStat->color('success')->descriptionColor('success');
        }

        return [
            Stat::make('Виллы', "{$villasPublished}")
                ->description($villasPublished === $villasTotal ? 'опубликовано' : "из {$villasTotal}")
                ->icon(Heroicon::OutlinedHomeModern)
                ->url(VillaResource::getUrl('index')),

            Stat::make('Рестораны', (string) $restaurantsTotal)
                ->description(
                    $restaurantsSoon > 0
                        ? "{$restaurantsSoon} скоро открытие"
                        : 'все открыты'
                )
                ->icon(Heroicon::OutlinedBuildingStorefront)
                ->url(RestaurantResource::getUrl('index'))
                ->descriptionColor($restaurantsSoon > 0 ? 'warning' : null),

            Stat::make('Отдых', "{$activities} · {$excursions}")
                ->description('активности · экскурсии')
                ->icon(Heroicon::OutlinedSparkles)
                ->url(ActivityResource::getUrl('index')),

            Stat::make('Блог', (string) $blogPublished)
                ->description($blogDescription)
                ->icon(Heroicon::OutlinedNewspaper)
                ->url(BlogPostResource::getUrl('index'))
                ->descriptionColor($blogDrafts > 0 ? 'warning' : null),

            Stat::make('Магазин', (string) $shopPublished)
                ->description('товары')
                ->icon(Heroicon::OutlinedShoppingBag)
                ->url(ShopProductResource::getUrl('index')),

            $exelyStat,
        ];
    }
}
