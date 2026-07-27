<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

/**
 * Helpers for building EN/RU tabs on top of Spatie translatable attributes.
 *
 * Every field is bound to a dotted state path like `title.en` / `title.ru`,
 * which Filament nests into `['title' => ['en' => ..., 'ru' => ...]]` when
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
        $en = $textarea
            ? Textarea::make("{$name}.en")->label("{$label} (EN)")->rows($rows)
            : TextInput::make("{$name}.en")->label("{$label} (EN)");

        $ru = $textarea
            ? Textarea::make("{$name}.ru")->label("{$label} (RU)")->rows($rows)
            : TextInput::make("{$name}.ru")->label("{$label} (RU)");

        if ($required) {
            $en->required();
        }

        return Tabs::make($name)
            ->label($label)
            ->contained(false)
            ->tabs([
                Tab::make('EN')->schema([$en]),
                Tab::make('RU')->schema([$ru]),
            ]);
    }

    /**
     * Translatable list of strings per locale (array cast attributes such
     * as facilities, polaroid dates, etc).
     */
    public static function tags(string $name, string $label): Tabs
    {
        return Tabs::make($name)
            ->label($label)
            ->contained(false)
            ->tabs([
                Tab::make('EN')->schema([
                    TagsInput::make("{$name}.en")->label("{$label} (EN)"),
                ]),
                Tab::make('RU')->schema([
                    TagsInput::make("{$name}.ru")->label("{$label} (RU)"),
                ]),
            ]);
    }

    /**
     * Translatable structured value (array of objects) per locale, edited
     * as pretty-printed JSON and decoded back on save.
     */
    public static function json(string $name, string $label): Tabs
    {
        $format = fn ($state) => is_array($state) ? json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $state;
        $dehydrate = fn ($state) => json_decode((string) $state, true) ?? [];

        return Tabs::make($name)
            ->label($label)
            ->contained(false)
            ->tabs([
                Tab::make('EN')->schema([
                    Textarea::make("{$name}.en")
                        ->label("{$label} (EN)")
                        ->rows(6)
                        ->formatStateUsing($format)
                        ->dehydrateStateUsing($dehydrate)
                        ->helperText('JSON'),
                ]),
                Tab::make('RU')->schema([
                    Textarea::make("{$name}.ru")
                        ->label("{$label} (RU)")
                        ->rows(6)
                        ->formatStateUsing($format)
                        ->dehydrateStateUsing($dehydrate)
                        ->helperText('JSON'),
                ]),
            ]);
    }
}
