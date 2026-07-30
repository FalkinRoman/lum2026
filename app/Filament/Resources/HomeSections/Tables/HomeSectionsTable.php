<?php

namespace App\Filament\Resources\HomeSections\Tables;

use App\Models\HomeSection;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HomeSectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Секция')
                    ->formatStateUsing(fn (string $state): string => HomeSection::LABELS[$state] ?? $state)
                    ->searchable()
                    ->sortable(false),
                TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([]);
    }
}
