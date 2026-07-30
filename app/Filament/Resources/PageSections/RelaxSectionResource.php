<?php

namespace App\Filament\Resources\PageSections;

use App\Filament\Resources\PageSections\Pages\EditRelaxSection;
use App\Filament\Resources\PageSections\Pages\ListRelaxSections;
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

class RelaxSectionResource extends Resource
{
    protected static ?string $model = PageSection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static string|UnitEnum|null $navigationGroup = 'Отдых';

    protected static ?string $navigationLabel = 'Секции';

    protected static ?int $navigationSort = 5;

    protected static ?string $modelLabel = 'Секция Relax';

    protected static ?string $pluralModelLabel = 'Секции Relax';

    protected static ?string $recordTitleAttribute = 'key';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return PageSectionForm::configure($schema, 'relax');
    }

    public static function table(Table $table): Table
    {
        return PageSectionsTable::configure($table, 'relax');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->onPage('relax')->ordered('relax');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRelaxSections::route('/'),
            'edit' => EditRelaxSection::route('/{record}/edit'),
        ];
    }
}
