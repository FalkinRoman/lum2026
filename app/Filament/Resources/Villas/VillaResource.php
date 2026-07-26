<?php

namespace App\Filament\Resources\Villas;

use App\Filament\Resources\Villas\Pages\CreateVilla;
use App\Filament\Resources\Villas\Pages\EditVilla;
use App\Filament\Resources\Villas\Pages\ListVillas;
use App\Filament\Resources\Villas\Schemas\VillaForm;
use App\Filament\Resources\Villas\Tables\VillasTable;
use App\Models\Villa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class VillaResource extends Resource
{
    protected static ?string $model = Villa::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHomeModern;

    protected static string|UnitEnum|null $navigationGroup = 'Catalog';

    protected static ?string $navigationLabel = 'Villas';

    protected static ?string $recordTitleAttribute = 'slug';

    public static function form(Schema $schema): Schema
    {
        return VillaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VillasTable::configure($table);
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
            'index' => ListVillas::route('/'),
            'create' => CreateVilla::route('/create'),
            'edit' => EditVilla::route('/{record}/edit'),
        ];
    }
}
