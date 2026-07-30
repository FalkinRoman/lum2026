<?php

namespace App\Filament\Resources\HomeSections\Schemas\Sections;

use App\Filament\Forms\LumImage;
use App\Support\Locales as AppLocales;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class HeroForm
{
    /**
     * @return array<int, \Filament\Schemas\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Section::make('Тексты')
                ->columnSpanFull()
                ->schema([
                    Tabs::make('locale')
                        ->contained(false)
                        ->tabs(array_map(
                            fn (string $locale) => Tab::make(AppLocales::label($locale))->schema(self::localeFields($locale)),
                            AppLocales::codes(),
                        )),
            TextInput::make('cta_url')
                        ->label('Ссылка кнопки')
                        ->nullable()
                        ->helperText('Пусто = страница Stay. Абсолютный URL или путь: /stay, /blog'),
                ]),

            Section::make('Видео')
                ->columnSpanFull()
                ->schema([
                    FileUpload::make('video')
                        ->label('Видео')
                        ->disk('lum')
                        ->directory('hero')
                        ->visibility('public')
                        ->acceptedFileTypes(['video/mp4', 'video/webm'])
                        ->maxSize(102400)
                        ->helperText('MP4 или WebM, лучше H.264. Пусто = на сайте тёмная заглушка (не seed-видео).')
                        ->nullable(),
                    LumImage::single(
                        'video_poster',
                        'Постер (до загрузки)',
                        'hero',
                        helperText: 'Если видео пусто — постер как статичный фон. Оба пусто = тёмная заглушка.',
                    ),
                    Select::make('video_position')
                        ->label('Позиция кадра (object-position)')
                        ->options([
                            'center' => 'Центр',
                            'top' => 'Верх',
                            'bottom' => 'Низ',
                        ])
                        ->default('center')
                        ->required(),
                ]),
        ];
    }

    /**
     * @return array<int, \Filament\Forms\Components\Field>
     */
    private static function localeFields(string $locale): array
    {
        return [
            TextInput::make("{$locale}.eyebrow_upper")->label('Eyebrow upper')->maxLength(255),
            TextInput::make("{$locale}.eyebrow_lower")->label('Eyebrow lower')->maxLength(255),
            TextInput::make("{$locale}.title_normal")->label('Title normal')->maxLength(255),
            TextInput::make("{$locale}.title_italic")->label('Title italic')->maxLength(255),
            TextInput::make("{$locale}.cta")->label('Текст кнопки')->maxLength(255),
        ];
    }
}
