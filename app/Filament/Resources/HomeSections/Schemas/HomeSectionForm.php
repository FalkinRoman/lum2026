<?php

namespace App\Filament\Resources\HomeSections\Schemas;

use App\Filament\Resources\HomeSections\Schemas\Sections\BlogForm;
use App\Filament\Resources\HomeSections\Schemas\Sections\HeroForm;
use App\Filament\Resources\HomeSections\Schemas\Sections\InteriorForm;
use App\Filament\Resources\HomeSections\Schemas\Sections\LocationForm;
use App\Filament\Resources\HomeSections\Schemas\Sections\PolaroidsForm;
use App\Filament\Resources\HomeSections\Schemas\Sections\ShopForm;
use App\Filament\Resources\HomeSections\Schemas\Sections\VillasForm;
use App\Models\HomeSection;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class HomeSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Секция')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('key')
                            ->label('Ключ')
                            ->disabled()
                            ->dehydrated()
                            ->helperText(fn (?string $state): string => HomeSection::LABELS[$state] ?? ''),
                    ]),

                Group::make(HeroForm::schema())
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => $get('key') === 'hero'),

                Group::make(PolaroidsForm::schema())
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => $get('key') === 'polaroids'),

                Group::make(VillasForm::schema())
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => $get('key') === 'villas_intro'),

                Group::make(LocationForm::schema())
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => $get('key') === 'location'),

                Group::make(InteriorForm::schema())
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => $get('key') === 'interior'),

                Group::make(BlogForm::schema())
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => $get('key') === 'blog'),

                Group::make(ShopForm::schema())
                    ->columnSpanFull()
                    ->visible(fn (Get $get): bool => $get('key') === 'shop_teaser'),
            ]);
    }
}
