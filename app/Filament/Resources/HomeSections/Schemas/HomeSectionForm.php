<?php

namespace App\Filament\Resources\HomeSections\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HomeSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Home section')
                    ->schema([
                        TextInput::make('key')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Textarea::make('payload')
                            ->label('Payload (JSON)')
                            ->rows(20)
                            ->required()
                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $state)
                            ->dehydrateStateUsing(fn ($state) => json_decode((string) $state, true) ?? [])
                            ->rules(['json'])
                            ->helperText('Pretty-printed JSON payload for this home page section.'),
                    ]),
            ]);
    }
}
