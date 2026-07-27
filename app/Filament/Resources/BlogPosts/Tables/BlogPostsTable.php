<?php

namespace App\Filament\Resources\BlogPosts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BlogPostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
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
                    ->searchable(false)
                    ->limit(40),
                IconColumn::make('is_published')
                    ->label('Опубликовано')
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),
                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
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
