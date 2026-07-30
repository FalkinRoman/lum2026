<?php

namespace App\Filament\Resources\HomeSections\Schemas\Sections;

use App\Filament\Forms\LumImage;
use App\Models\Villa;
use App\Support\Locales as AppLocales;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class VillasForm
{
    /**
     * @return array<int, \Filament\Schemas\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Section::make('Заголовок и текст')
                ->description('Слово lifestyle в тексте пиши как :lifestyle — на сайте оно будет script-стилем.')
                ->columnSpanFull()
                ->schema([
                    Tabs::make('locale')
                        ->contained(false)
                        ->tabs(array_map(
                            fn (string $locale) => Tab::make(AppLocales::label($locale))->schema(self::localeFields($locale)),
                            AppLocales::codes(),
                        )),
                ]),

            Section::make('Карусель')
                ->description('1–4 слайда. VIEW/ссылка — из виллы. Одна вилла = один слайд: если выбрать уже занятую — слайды меняются местами.')
                ->columnSpanFull()
                ->schema([
                    Repeater::make('slides')
                        ->label('Слайды')
                        ->defaultItems(4)
                        ->minItems(1)
                        ->maxItems(4)
                        ->reorderable()
                        ->addable()
                        ->deletable()
                        ->addActionLabel('Добавить слайд')
                        ->schema([
                            Select::make('villa_id')
                                ->label('Вилла')
                                ->options(fn (): array => self::villaOptions())
                                ->searchable()
                                ->nullable()
                                ->live()
                                ->afterStateUpdated(function (mixed $state, mixed $old, Set $set, Get $get, Select $component): void {
                                    self::onVillaSelected($state, $old, $set, $get, $component);
                                }),
                            Hidden::make('slug'),
                            Tabs::make('slide_locale')
                                ->contained(false)
                                ->tabs(array_map(
                                    fn (string $locale) => Tab::make(AppLocales::label($locale))->schema(self::slideLocaleFields($locale)),
                                    AppLocales::codes(),
                                )),
                            LumImage::single(
                                'photo',
                                'Фото слайда',
                                'villas',
                                helperText: 'JPG/PNG/WebP ок. Не обязательно -sm вариант — CMS-файл используется как есть.',
                            ),
                            LumImage::single(
                                'oval',
                                'Овал',
                                'villas',
                                helperText: 'JPG/PNG/WebP ок.',
                            ),
                        ])
                        ->itemLabel(function (array $state): ?string {
                            $slug = $state['slug'] ?? null;
                            $title = trim((string) (data_get($state, 'title_normal.en').' '.data_get($state, 'title_italic.en')));

                            if ($slug) {
                                return 'Слайд: '.$slug;
                            }

                            return $title !== '' ? 'Слайд: '.$title : 'Слайд';
                        }),
                ]),
        ];
    }

    /**
     * @return array<int|string, string>
     */
    private static function villaOptions(): array
    {
        return Villa::query()
            ->orderBy('sort_order')
            ->get()
            ->mapWithKeys(fn (Villa $v) => [
                $v->id => trim(($v->title_normal ?: '').' '.($v->title_italic ?: ''))
                    .' ('.$v->slug.')',
            ])
            ->all();
    }

    private static function onVillaSelected(mixed $state, mixed $old, Set $set, Get $get, Select $component): void
    {
        $newId = filled($state) ? (int) $state : null;
        if (! $newId) {
            return;
        }

        $slides = $get('/slides');
        if (! is_array($slides)) {
            self::fillFromVilla($set, $newId);

            return;
        }

        $path = (string) $component->getStatePath();
        $currentKey = null;
        if (preg_match('/(?:^|\.)slides\.([^.]+)\.villa_id$/', $path, $m) === 1) {
            $currentKey = $m[1];
        }

        $otherKey = null;
        foreach ($slides as $key => $item) {
            if ((string) $key === (string) $currentKey) {
                continue;
            }
            if ((int) ($item['villa_id'] ?? 0) === $newId) {
                $otherKey = $key;
                break;
            }
        }

        if ($currentKey !== null && $otherKey !== null) {
            $current = is_array($slides[$currentKey] ?? null) ? $slides[$currentKey] : [];
            $other = is_array($slides[$otherKey] ?? null) ? $slides[$otherKey] : [];

            // afterStateUpdated already wrote new villa_id onto current — restore old before swap.
            $current['villa_id'] = filled($old) ? (int) $old : null;

            $slides[$currentKey] = $other;
            $slides[$otherKey] = $current;
            $set('/slides', $slides);

            return;
        }

        self::fillFromVilla($set, $newId);
    }

    private static function fillFromVilla(Set $set, int $villaId): void
    {
        $villa = Villa::query()->find($villaId);
        if (! $villa) {
            return;
        }

        $set('slug', $villa->slug);
        $set('photo', $villa->slide_photo);
        $set('oval', $villa->slide_oval);
        foreach (AppLocales::codes() as $locale) {
            $set("title_normal.{$locale}", $villa->getTranslation('title_normal', $locale));
            $set("title_italic.{$locale}", $villa->getTranslation('title_italic', $locale));
            $set("subtitle.{$locale}", $villa->getTranslation('subtitle', $locale));
            $set("subtitle_line1.{$locale}", $villa->getTranslation('subtitle_line1', $locale));
            $set("subtitle_line2.{$locale}", $villa->getTranslation('subtitle_line2', $locale));
        }
    }

    /**
     * @return array<int, \Filament\Forms\Components\Field>
     */
    private static function localeFields(string $locale): array
    {
        return [
            TextInput::make("{$locale}.eyebrow")
                ->label('Заголовок (eyebrow)')
                ->maxLength(255),
            TextInput::make("{$locale}.lifestyle")
                ->label('Слово :lifestyle (script)')
                ->maxLength(64)
                ->helperText('Подставится вместо :lifestyle в текстах ниже'),
            Textarea::make("{$locale}.intro_desk")
                ->label('Текст — Desktop')
                ->rows(4)
                ->helperText('Каждая строка = отдельный абзац. Вставь :lifestyle где нужен script.'),
            Textarea::make("{$locale}.intro_tablet")
                ->label('Текст — Tablet')
                ->rows(3)
                ->helperText('Каждая строка = абзац. :lifestyle где нужно.'),
            Textarea::make("{$locale}.intro_mobile")
                ->label('Текст — Mobile')
                ->rows(5)
                ->helperText('Каждая строка = абзац. :lifestyle где нужно.'),
        ];
    }

    /**
     * @return array<int, \Filament\Forms\Components\Field>
     */
    private static function slideLocaleFields(string $locale): array
    {
        return [
            TextInput::make("title_normal.{$locale}")->label('Название (обычный)')->maxLength(255),
            TextInput::make("title_italic.{$locale}")->label('Название (italic)')->maxLength(255),
            Textarea::make("subtitle.{$locale}")
                ->label('Описание — Desktop / Tablet')
                ->rows(2)
                ->helperText('Одна строка под заголовком слайда'),
            TextInput::make("subtitle_line1.{$locale}")
                ->label('Описание — Mobile, строка 1'),
            TextInput::make("subtitle_line2.{$locale}")
                ->label('Описание — Mobile, строка 2'),
        ];
    }
}
