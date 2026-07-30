<?php

namespace App\Filament\Pages;

use App\Filament\Forms\Locales;
use App\Filament\Forms\LumImage;
use App\Models\SiteSetting;
use App\Support\Locales as AppLocales;
use App\Support\Site;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageSiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Настройки';

    protected static ?string $navigationLabel = 'Настройки сайта';

    protected static ?int $navigationSort = 90;

    protected static ?string $title = 'Настройки сайта';

    protected string $view = 'filament.pages.manage-site-settings';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $settings = SiteSetting::current();

        $this->form->fill([
            'phone' => $settings->phone,
            'phone_personal' => $settings->phone_personal,
            'email' => $settings->email,
            'map_url' => $settings->map_url,
            'menu_image' => $settings->menu_image ?: 'menu/map.jpg',
            'whatsapp_url' => $settings->whatsapp_url,
            'instagram_url' => $settings->instagram_url,
            'telegram_url' => $settings->telegram_url,
            'use_booking_page' => $settings->use_booking_page ?? true,
            'book_url' => $settings->book_url ?: $settings->take_a_break_url,
            'address' => collect(AppLocales::codes())
                ->mapWithKeys(fn (string $locale): array => [
                    $locale => $settings->getTranslation('address', $locale, useFallbackLocale: false),
                ])
                ->all(),
            'footer_address' => collect(AppLocales::codes())
                ->mapWithKeys(fn (string $locale): array => [
                    $locale => $settings->getTranslation('footer_address', $locale, useFallbackLocale: false) ?? [],
                ])
                ->all(),
            'hours_editor' => $this->pairRowsToEditor($settings, 'hours'),
            'legal_editor' => $this->legalRowsWithoutPhone($settings),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Общие контакты')
                    ->columns(2)
                    ->schema([
                        TextInput::make('phone')
                            ->label('Телефон виллы (ресепшн)')
                            ->required(),
                        TextInput::make('phone_personal')
                            ->label('Телефон личный'),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required(),
                        TextInput::make('map_url')
                            ->label('URL карты')
                            ->url(),
                        LumImage::single(
                            'menu_image',
                            'Картинка в меню (хедер)',
                            'menu',
                            helperText: 'Большое фото справа в открытом меню. Пусто = menu/map.jpg по умолчанию.',
                        )->columnSpanFull(),
                        TextInput::make('instagram_url')->label('Instagram URL')->url(),
                        TextInput::make('whatsapp_url')->label('WhatsApp URL')->url(),
                        TextInput::make('telegram_url')->label('Telegram URL')->url()->columnSpanFull(),
                    ]),

                Section::make('Бронирование')
                    ->description('Кнопки «Take a break» (хедер и меню) и Book (активности, экскурсии и похожие CTA).')
                    ->schema([
                        Radio::make('use_booking_page')
                            ->label('Куда вести эти кнопки')
                            ->boolean(
                                trueLabel: 'На страницу /booking на сайте',
                                falseLabel: 'На внешнюю ссылку',
                            )
                            ->default(true)
                            ->live()
                            ->required(),
                        TextInput::make('book_url')
                            ->label('Внешняя ссылка')
                            ->url()
                            ->placeholder('https://...')
                            ->helperText('WhatsApp, Booking.com или другой URL')
                            ->visible(fn ($get) => ! $get('use_booking_page'))
                            ->required(fn ($get) => ! $get('use_booking_page')),
                    ]),

                Section::make('Страница «Контакты»')
                    ->schema([
                        Locales::text('address', 'Адрес', textarea: true),
                        Repeater::make('hours_editor')
                            ->label('Часы работы')
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->default([])
                            ->schema([
                                Grid::make(count(AppLocales::codes()) * 2)->schema(
                                    collect(AppLocales::codes())->flatMap(fn (string $locale): array => [
                                        TextInput::make("label_{$locale}")
                                            ->label('Дни ('.AppLocales::label($locale).')'),
                                        TextInput::make("value_{$locale}")
                                            ->label('Время ('.AppLocales::label($locale).')'),
                                    ])->all()
                                ),
                            ]),
                        Repeater::make('legal_editor')
                            ->label('Реквизиты')
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->default([])
                            ->schema([
                                Grid::make(count(AppLocales::codes()) * 2)->schema(
                                    collect(AppLocales::codes())->flatMap(fn (string $locale): array => [
                                        TextInput::make("label_{$locale}")
                                            ->label('Подпись ('.AppLocales::label($locale).')'),
                                        TextInput::make("value_{$locale}")
                                            ->label('Значение ('.AppLocales::label($locale).')'),
                                    ])->all()
                                ),
                            ]),
                    ]),

                Section::make('Футер')
                    ->schema([
                        Locales::json('footer_address', 'Адрес (массив строк)'),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Сохранить')
                ->icon(Heroicon::OutlinedCheck)
                ->action('save'),
        ];
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $state['hours'] = $this->editorToPairRows($state['hours_editor'] ?? []);
        $state['legal'] = $this->mergePersonalPhoneIntoLegal(
            $this->editorToPairRows($state['legal_editor'] ?? []),
            (string) ($state['phone_personal'] ?? '')
        );
        unset($state['hours_editor'], $state['legal_editor']);

        $state['use_booking_page'] = (bool) ($state['use_booking_page'] ?? true);

        // Keep legacy CTA field in sync with the single booking URL.
        $state['take_a_break_url'] = $state['book_url'] ?? null;

        $menuImage = $state['menu_image'] ?? null;
        if (is_array($menuImage)) {
            $menuImage = $menuImage[0] ?? null;
        }
        $state['menu_image'] = is_string($menuImage) && trim($menuImage) !== ''
            ? ltrim($menuImage, '/')
            : null;

        // tel: links are derived from phone numbers in code — keep DB columns in sync.
        $state['phone_href'] = self::telFromPhone((string) ($state['phone'] ?? ''));
        $state['phone_personal_href'] = self::telFromPhone((string) ($state['phone_personal'] ?? ''));

        $settings = SiteSetting::current();
        $settings->fill($state);
        $settings->save();

        Site::forget();

        Notification::make()
            ->title('Настройки сохранены')
            ->success()
            ->send();
    }

    protected static function telFromPhone(string $phone): ?string
    {
        $digits = preg_replace('/[^\d+]/', '', $phone);

        return $digits !== '' ? 'tel:'.$digits : null;
    }

    /**
     * @return array<int, array<string, string>>
     */
    protected function legalRowsWithoutPhone(SiteSetting $settings): array
    {
        $phoneLabels = array_map(
            fn (string $locale): string => mb_strtolower(AppLocales::phoneLabel($locale)),
            AppLocales::codes(),
        );
        $phoneLabels[] = 'phone';

        return array_values(array_filter(
            $this->pairRowsToEditor($settings, 'legal'),
            function (array $row) use ($phoneLabels): bool {
                foreach (AppLocales::codes() as $locale) {
                    $label = mb_strtolower(trim((string) ($row["label_{$locale}"] ?? '')));
                    if (in_array($label, $phoneLabels, true)) {
                        return false;
                    }
                }

                return true;
            }
        ));
    }

    /**
     * @param  array<string, list<array{label: string, value: string}>>  $legal
     * @return array<string, list<array{label: string, value: string}>>
     */
    protected function mergePersonalPhoneIntoLegal(array $legal, string $phonePersonal): array
    {
        $phoneLabels = array_map(
            fn (string $locale): string => mb_strtolower(AppLocales::phoneLabel($locale)),
            AppLocales::codes(),
        );
        $phoneLabels[] = 'phone';

        foreach (AppLocales::codes() as $locale) {
            $legal[$locale] = array_values(array_filter(
                $legal[$locale] ?? [],
                function (array $row) use ($phoneLabels): bool {
                    $label = mb_strtolower(trim((string) ($row['label'] ?? '')));

                    return ! in_array($label, $phoneLabels, true);
                }
            ));

            if ($phonePersonal !== '') {
                array_splice($legal[$locale], min(1, count($legal[$locale])), 0, [[
                    'label' => AppLocales::phoneLabel($locale),
                    'value' => $phonePersonal,
                ]]);
            }
        }

        return $legal;
    }

    /**
     * @return array<int, array<string, string>>
     */
    protected function pairRowsToEditor(SiteSetting $settings, string $field): array
    {
        $byLocale = [];
        foreach (AppLocales::codes() as $locale) {
            $byLocale[$locale] = $settings->getTranslation($field, $locale, useFallbackLocale: false) ?? [];
        }
        $count = max(array_map('count', $byLocale));
        $rows = [];

        for ($i = 0; $i < $count; $i++) {
            $row = [];
            foreach (AppLocales::codes() as $locale) {
                $row["label_{$locale}"] = $byLocale[$locale][$i]['label'] ?? '';
                $row["value_{$locale}"] = $byLocale[$locale][$i]['value'] ?? '';
            }
            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * @param  array<int, array<string, string>>  $rows
     * @return array<string, list<array{label: string, value: string}>>
     */
    protected function editorToPairRows(array $rows): array
    {
        $result = array_fill_keys(AppLocales::codes(), []);

        foreach ($rows as $row) {
            foreach (AppLocales::codes() as $locale) {
                $result[$locale][] = [
                    'label' => $row["label_{$locale}"] ?? '',
                    'value' => $row["value_{$locale}"] ?? '',
                ];
            }
        }

        return $result;
    }
}
