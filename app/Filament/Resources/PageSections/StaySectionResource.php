<?php

namespace App\Filament\Resources\PageSections;

use App\Filament\Resources\PageSections\Pages\EditStaySection;
use App\Filament\Resources\PageSections\Pages\ListStaySections;
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

class StaySectionResource extends Resource
{
    protected static ?string $model = PageSection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static string|UnitEnum|null $navigationGroup = 'Проживание';

    protected static ?string $navigationLabel = 'Секции';

    protected static ?int $navigationSort = 5;

    protected static ?string $modelLabel = 'Секция Stay';

    protected static ?string $pluralModelLabel = 'Секции Stay';

    protected static ?string $recordTitleAttribute = 'key';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return PageSectionForm::configure($schema, 'stay');
    }

    public static function table(Table $table): Table
    {
        return PageSectionsTable::configure($table, 'stay');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->onPage('stay')->ordered('stay');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStaySections::route('/'),
            'edit' => EditStaySection::route('/{record}/edit'),
        ];
    }
}
