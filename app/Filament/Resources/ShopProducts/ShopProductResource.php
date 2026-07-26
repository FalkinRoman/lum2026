<?php

namespace App\Filament\Resources\ShopProducts;

use App\Filament\Resources\ShopProducts\Pages\CreateShopProduct;
use App\Filament\Resources\ShopProducts\Pages\EditShopProduct;
use App\Filament\Resources\ShopProducts\Pages\ListShopProducts;
use App\Filament\Resources\ShopProducts\Schemas\ShopProductForm;
use App\Filament\Resources\ShopProducts\Tables\ShopProductsTable;
use App\Models\ShopProduct;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ShopProductResource extends Resource
{
    protected static ?string $model = ShopProduct::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingBag;

    protected static string|UnitEnum|null $navigationGroup = 'Catalog';

    protected static ?string $navigationLabel = 'Shop products';

    protected static ?string $recordTitleAttribute = 'slug';

    public static function form(Schema $schema): Schema
    {
        return ShopProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ShopProductsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListShopProducts::route('/'),
            'create' => CreateShopProduct::route('/create'),
            'edit' => EditShopProduct::route('/{record}/edit'),
        ];
    }
}
