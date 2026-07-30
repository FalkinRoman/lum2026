<?php

namespace App\Filament\Resources\MenuCategories\RelationManagers;

use App\Filament\Forms\Locales;
use App\Filament\Forms\LumImage;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MenuItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Позиции меню';

    protected static string|BackedEnum|null $icon = Heroicon::OutlinedQueueList;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Позиция')
                    ->columns(2)
                    ->schema([
                        TextInput::make('sort_order')
                            ->label('Порядок')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required(),
                        LumImage::single('image', 'Изображение', 'dining/menu'),
                    ]),

                Locales::text('name', 'Название', required: true),
                Locales::text('description', 'Описание', textarea: true),
                Locales::text('price', 'Цена'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('image')
                    ->label('')
                    ->disk('lum')
                    ->height(40)
                    ->width(40)
                    ->circular()
                    ->defaultImageUrl(null),
                TextColumn::make('name')
                    ->label('Название (EN)')
                    ->getStateUsing(fn ($record) => $record->getTranslation('name', 'en'))
                    ->limit(40),
                TextColumn::make('price')
                    ->label('Цена (EN)')
                    ->getStateUsing(fn ($record) => $record->getTranslation('price', 'en')),
                TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->paginated([10, 25, 50])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
