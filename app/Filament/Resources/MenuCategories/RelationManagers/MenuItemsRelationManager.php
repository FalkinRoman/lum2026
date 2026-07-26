<?php

namespace App\Filament\Resources\MenuCategories\RelationManagers;

use App\Filament\Forms\Locales;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MenuItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static string|BackedEnum|null $icon = Heroicon::OutlinedQueueList;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Item')
                    ->columns(2)
                    ->schema([
                        TextInput::make('sort_order')
                            ->label('Sort order')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        TextInput::make('image')
                            ->label('Image path'),
                    ]),

                Locales::text('name', 'Name', required: true),
                Locales::text('description', 'Description', textarea: true),
                Locales::text('price', 'Price'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Name (EN)')
                    ->getStateUsing(fn ($record) => $record->getTranslation('name', 'en'))
                    ->limit(40),
                TextColumn::make('price')
                    ->label('Price (EN)')
                    ->getStateUsing(fn ($record) => $record->getTranslation('price', 'en')),
                TextColumn::make('sort_order')
                    ->label('Sort order')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
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
