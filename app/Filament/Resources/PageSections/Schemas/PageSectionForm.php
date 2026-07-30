<?php

namespace App\Filament\Resources\PageSections\Schemas;

use App\Filament\Resources\PageSections\Schemas\Sections\DiscoverIntroForm;
use App\Filament\Resources\PageSections\Schemas\Sections\MediaForm;
use App\Filament\Resources\PageSections\Schemas\Sections\QuoteForm;
use App\Filament\Resources\PageSections\Schemas\Sections\RelaxIntroForm;
use App\Filament\Resources\PageSections\Schemas\Sections\StayQuoteForm;
use App\Filament\Resources\PageSections\Schemas\Sections\TitleIntroForm;
use App\Models\PageSection;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class PageSectionForm
{
    public static function configure(Schema $schema, string $page): Schema
    {
        $labels = PageSection::labelsFor($page);

        return $schema
            ->columns(1)
            ->components([
                Section::make('Секция')
                    ->columnSpanFull()
                    ->schema([
                        Hidden::make('page')->default($page)->dehydrated(),
                        TextInput::make('key')
                            ->label('Ключ')
                            ->disabled()
                            ->dehydrated()
                            ->helperText(fn (?string $state): string => $labels[$state] ?? ''),
                    ]),

                ...self::groupsFor($page),
            ]);
    }

    /**
     * @return array<int, Group>
     */
    private static function groupsFor(string $page): array
    {
        return match ($page) {
            'stay' => [
                Group::make(TitleIntroForm::schema())
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => $get('key') === 'intro'),
                Group::make(MediaForm::schema('stay'))
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => $get('key') === 'media'),
                Group::make(StayQuoteForm::schema())
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => $get('key') === 'quote'),
            ],
            'dining' => [
                Group::make(TitleIntroForm::schema())
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => $get('key') === 'intro'),
                Group::make(MediaForm::schema('dining'))
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => $get('key') === 'media'),
                Group::make(QuoteForm::schema())
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => $get('key') === 'quote'),
            ],
            'relax' => [
                Group::make(RelaxIntroForm::schema())
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => $get('key') === 'intro'),
                Group::make(MediaForm::schema('relax', breakpointHeroes: true))
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => $get('key') === 'media'),
                Group::make(QuoteForm::schema())
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => $get('key') === 'quote'),
            ],
            'discover' => [
                Group::make(DiscoverIntroForm::schema())
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => $get('key') === 'intro'),
            ],
            default => [],
        };
    }
}
