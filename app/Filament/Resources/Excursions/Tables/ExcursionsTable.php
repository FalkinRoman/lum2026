<?php

namespace App\Filament\Resources\Excursions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ExcursionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('listing_image')
                    ->label('')
                    ->disk('lum')
                    ->height(48)
                    ->width(48)
                    ->square(),
                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Заголовок (EN)')
                    ->getStateUsing(fn ($record) => $record->getTranslation('title', 'en'))
                    ->limit(40),
                IconColumn::make('is_published')
                    ->label('Опубликовано')
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Опубликовано'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
