<?php

namespace App\Filament\Pages;

use App\Filament\Forms\Locales;
use App\Models\SiteSetting;
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
            'whatsapp_url' => $settings->whatsapp_url,
            'instagram_url' => $settings->instagram_url,
            'telegram_url' => $settings->telegram_url,
            'use_booking_page' => $settings->use_booking_page ?? true,
            'book_url' => $settings->book_url ?: $settings->take_a_break_url,
            'address' => [
                'en' => $settings->getTranslation('address', 'en', useFallbackLocale: false),
                'ru' => $settings->getTranslation('address', 'ru', useFallbackLocale: false),
            ],
            'footer_address' => [
                'en' => $settings->getTranslation('footer_address', 'en', useFallbackLocale: false) ?? [],
                'ru' => $settings->getTranslation('footer_address', 'ru', useFallbackLocale: false) ?? [],
            ],
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
                                Grid::make(4)->schema([
                                    TextInput::make('label_en')->label('Дни (EN)'),
                                    TextInput::make('label_ru')->label('Дни (RU)'),
                                    TextInput::make('value_en')->label('Время (EN)'),
                                    TextInput::make('value_ru')->label('Время (RU)'),
                                ]),
                            ]),
                        Repeater::make('legal_editor')
                            ->label('Реквизиты')
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->default([])
                            ->schema([
                                Grid::make(4)->schema([
                                    TextInput::make('label_en')->label('Подпись (EN)'),
                                    TextInput::make('label_ru')->label('Подпись (RU)'),
                                    TextInput::make('value_en')->label('Значение (EN)'),
                                    TextInput::make('value_ru')->label('Значение (RU)'),
                                ]),
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
        return array_values(array_filter(
            $this->pairRowsToEditor($settings, 'legal'),
            function (array $row): bool {
                $en = mb_strtolower(trim((string) ($row['label_en'] ?? '')));
                $ru = mb_strtolower(trim((string) ($row['label_ru'] ?? '')));

                return ! in_array($en, ['phone'], true) && ! in_array($ru, ['телефон', 'phone'], true);
            }
        ));
    }

    /**
     * @param  array{en: list<array{label: string, value: string}>, ru: list<array{label: string, value: string}>}  $legal
     * @return array{en: list<array{label: string, value: string}>, ru: list<array{label: string, value: string}>}
     */
    protected function mergePersonalPhoneIntoLegal(array $legal, string $phonePersonal): array
    {
        foreach (['en', 'ru'] as $locale) {
            $legal[$locale] = array_values(array_filter(
                $legal[$locale] ?? [],
                function (array $row): bool {
                    $label = mb_strtolower(trim((string) ($row['label'] ?? '')));

                    return ! in_array($label, ['phone', 'телефон'], true);
                }
            ));

            if ($phonePersonal !== '') {
                array_splice($legal[$locale], min(1, count($legal[$locale])), 0, [[
                    'label' => $locale === 'ru' ? 'Телефон' : 'Phone',
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
        $en = $settings->getTranslation($field, 'en', useFallbackLocale: false) ?? [];
        $ru = $settings->getTranslation($field, 'ru', useFallbackLocale: false) ?? [];
        $count = max(count($en), count($ru));
        $rows = [];

        for ($i = 0; $i < $count; $i++) {
            $rows[] = [
                'label_en' => $en[$i]['label'] ?? '',
                'label_ru' => $ru[$i]['label'] ?? '',
                'value_en' => $en[$i]['value'] ?? '',
                'value_ru' => $ru[$i]['value'] ?? '',
            ];
        }

        return $rows;
    }

    /**
     * @param  array<int, array<string, string>>  $rows
     * @return array{en: list<array{label: string, value: string}>, ru: list<array{label: string, value: string}>}
     */
    protected function editorToPairRows(array $rows): array
    {
        $en = [];
        $ru = [];

        foreach ($rows as $row) {
            $en[] = ['label' => $row['label_en'] ?? '', 'value' => $row['value_en'] ?? ''];
            $ru[] = ['label' => $row['label_ru'] ?? '', 'value' => $row['value_ru'] ?? ''];
        }

        return ['en' => $en, 'ru' => $ru];
    }
}
