<?php

namespace App\Filament\Forms;

use App\Support\Locales as AppLocales;
use Closure;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

/**
 * Helpers for building locale tabs on top of Spatie translatable attributes.
 *
 * Every field is bound to a dotted state path like `title.en` / `title.ru` / `title.zh`,
 * which Filament nests into `['title' => ['en' => ..., 'ru' => ..., 'zh' => ...]]` when
 * the form state is gathered. Assigning that array back onto the model
 * (via fill/create) is exactly what `Spatie\Translatable\HasTranslations`
 * expects, so no extra glue is needed on the resource/page side.
 */
class Locales
{
    /**
     * Plain translatable text/textarea field (string per locale).
     */
    public static function text(string $name, string $label, bool $textarea = false, bool $required = false, int $rows = 3): Tabs
    {
        $tabs = [];

        foreach (AppLocales::codes() as $locale) {
            $fieldLabel = "{$label} (".AppLocales::label($locale).')';
            $field = $textarea
                ? Textarea::make("{$name}.{$locale}")->label($fieldLabel)->rows($rows)
                : TextInput::make("{$name}.{$locale}")->label($fieldLabel);

            if ($required && $locale === 'en') {
                $field->required();
            }

            $tabs[] = Tab::make(AppLocales::label($locale))->schema([$field]);
        }

        return Tabs::make($name)
            ->label($label)
            ->contained(false)
            ->tabs($tabs);
    }

    /**
     * Translatable list of strings per locale (array cast attributes such
     * as facilities, polaroid dates, etc).
     */
    public static function tags(string $name, string $label): Tabs
    {
        $tabs = [];

        foreach (AppLocales::codes() as $locale) {
            $tabs[] = Tab::make(AppLocales::label($locale))->schema([
                TagsInput::make("{$name}.{$locale}")
                    ->label("{$label} (".AppLocales::label($locale).')'),
            ]);
        }

        return Tabs::make($name)
            ->label($label)
            ->contained(false)
            ->tabs($tabs);
    }

    /**
     * Translatable list of plain strings as addable blocks (not tags/chips).
     * Stored as `['en' => ['…', '…'], 'ru' => [...], 'zh' => [...]]`.
     */
    public static function stringList(
        string $name,
        string $label,
        string $addActionLabel = 'Добавить пункт',
        string $placeholder = 'Текст пункта',
    ): Tabs {
        $make = function (string $locale) use ($name, $label, $addActionLabel, $placeholder): Repeater {
            return Repeater::make("{$name}.{$locale}")
                ->label("{$label} (".AppLocales::label($locale).')')
                ->simple(
                    TextInput::make('text')
                        ->placeholder($placeholder)
                        ->required(),
                )
                ->reorderable()
                ->defaultItems(0)
                ->addActionLabel($addActionLabel)
                ->columnSpanFull();
        };

        return Tabs::make($name)
            ->label($label)
            ->contained(false)
            ->tabs(array_map(
                fn (string $locale) => Tab::make(AppLocales::label($locale))->schema([$make($locale)]),
                AppLocales::codes(),
            ));
    }

    /**
     * Translatable list of objects as addable blocks.
     * Stored as `['en' => [['title' => …], …], 'ru' => [...], 'zh' => [...]]`.
     *
     * @param  array<int, \Filament\Forms\Components\Component>  $itemSchema
     */
    public static function objectList(
        string $name,
        string $label,
        array $itemSchema,
        ?Closure $itemLabel = null,
        string $addActionLabel = 'Добавить позицию',
        int | array $columns = 1,
    ): Tabs {
        $make = function (string $locale) use ($name, $label, $itemSchema, $itemLabel, $addActionLabel, $columns): Repeater {
            $repeater = Repeater::make("{$name}.{$locale}")
                ->label("{$label} (".AppLocales::label($locale).')')
                ->schema($itemSchema)
                ->reorderable()
                ->defaultItems(0)
                ->addActionLabel($addActionLabel)
                ->columns($columns)
                ->columnSpanFull();

            if ($itemLabel !== null) {
                $repeater->itemLabel($itemLabel);
            }

            return $repeater;
        };

        return Tabs::make($name)
            ->label($label)
            ->contained(false)
            ->tabs(array_map(
                fn (string $locale) => Tab::make(AppLocales::label($locale))->schema([$make($locale)]),
                AppLocales::codes(),
            ));
    }

    /**
     * Translatable structured value (array of objects) per locale, edited
     * as pretty-printed JSON and decoded back on save.
     *
     * @deprecated Prefer objectList() / stringList() for admin UX.
     */
    public static function json(string $name, string $label): Tabs
    {
        $format = fn ($state) => is_array($state) ? json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $state;
        $dehydrate = fn ($state) => json_decode((string) $state, true) ?? [];

        $tabs = [];

        foreach (AppLocales::codes() as $locale) {
            $tabs[] = Tab::make(AppLocales::label($locale))->schema([
                Textarea::make("{$name}.{$locale}")
                    ->label("{$label} (".AppLocales::label($locale).')')
                    ->rows(6)
                    ->formatStateUsing($format)
                    ->dehydrateStateUsing($dehydrate)
                    ->helperText('JSON'),
            ]);
        }

        return Tabs::make($name)
            ->label($label)
            ->contained(false)
            ->tabs($tabs);
    }
}
