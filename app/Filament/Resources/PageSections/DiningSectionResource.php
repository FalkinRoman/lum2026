<?php

namespace App\Filament\Resources\PageSections;

use App\Filament\Resources\PageSections\Pages\EditDiningSection;
use App\Filament\Resources\PageSections\Pages\ListDiningSections;
use App\Filament\Resources\PageSections\Schemas\PageSectionForm;
use App\Filament\Resources\PageSections\Tables\PageSectionsTable;
use App\Models\PageSection;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class DiningSectionResource extends Resource
{
    protected static ?string $model = PageSection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static string|UnitEnum|null $navigationGroup = 'Гастрономия';

    protected static ?string $navigationLabel = 'Секции';

    protected static ?int $navigationSort = 5;

    protected static ?string $modelLabel = 'Секция Dining';

    protected static ?string $pluralModelLabel = 'Секции Dining';

    protected static ?string $recordTitleAttribute = 'key';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return PageSectionForm::configure($schema, 'dining');
    }

    public static function table(Table $table): Table
    {
        return PageSectionsTable::configure($table, 'dining');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->onPage('dining')->ordered('dining');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDiningSections::route('/'),
            'edit' => EditDiningSection::route('/{record}/edit'),
        ];
    }
}
