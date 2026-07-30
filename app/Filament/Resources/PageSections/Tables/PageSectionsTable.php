<?php

namespace App\Filament\Resources\PageSections\Tables;

use App\Models\PageSection;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PageSectionsTable
{
    public static function configure(Table $table, string $page): Table
    {
        $labels = PageSection::labelsFor($page);

        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Секция')
                    ->formatStateUsing(fn (string $state): string => $labels[$state] ?? $state)
                    ->searchable()
                    ->sortable(false),
                TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime()
                    ->sortable(false),
            ])
            ->defaultSort(null)
            ->paginated(false)
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([]);
    }
}
