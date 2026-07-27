<?php

namespace App\Filament\Pages;

use App\Filament\Forms\Locales;
use App\Models\SiteSetting;
use App\Support\Site;
use BackedEnum;
use Filament\Actions\Action;
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
            'phone_href' => $settings->phone_href,
            'email' => $settings->email,
            'map_url' => $settings->map_url,
            'whatsapp_url' => $settings->whatsapp_url,
            'instagram_url' => $settings->instagram_url,
            'telegram_url' => $settings->telegram_url,
            'take_a_break_url' => $settings->take_a_break_url,
            'book_url' => $settings->book_url,
            'address' => [
                'en' => $settings->getTranslation('address', 'en', useFallbackLocale: false),
                'ru' => $settings->getTranslation('address', 'ru', useFallbackLocale: false),
            ],
            'footer_address' => [
                'en' => $settings->getTranslation('footer_address', 'en', useFallbackLocale: false) ?? [],
                'ru' => $settings->getTranslation('footer_address', 'ru', useFallbackLocale: false) ?? [],
            ],
            'reviews' => [
                'en' => $settings->getTranslation('reviews', 'en', useFallbackLocale: false),
                'ru' => $settings->getTranslation('reviews', 'ru', useFallbackLocale: false),
            ],
            'copyright' => [
                'en' => $settings->getTranslation('copyright', 'en', useFallbackLocale: false),
                'ru' => $settings->getTranslation('copyright', 'ru', useFallbackLocale: false),
            ],
            'legal' => [
                'en' => $settings->getTranslation('legal', 'en', useFallbackLocale: false) ?? [],
                'ru' => $settings->getTranslation('legal', 'ru', useFallbackLocale: false) ?? [],
            ],
            'hours_editor' => $this->hoursToRows($settings),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Контакты')
                    ->columns(2)
                    ->schema([
                        TextInput::make('phone')->label('Телефон'),
                        TextInput::make('phone_href')->label('Ссылка телефона')->helperText('например tel:+94779296087'),
                        TextInput::make('email')->label('Email')->email(),
                        TextInput::make('map_url')->label('URL карты')->url(),
                        TextInput::make('whatsapp_url')->label('WhatsApp URL')->url(),
                        TextInput::make('instagram_url')->label('Instagram URL')->url(),
                        TextInput::make('telegram_url')->label('Telegram URL')->url(),
                        TextInput::make('take_a_break_url')
                            ->label('URL «Take a break»')
                            ->url()
                            ->helperText('Игнорируется при включённом Exely — CTA ведут на /booking'),
                        TextInput::make('book_url')
                            ->label('URL бронирования')
                            ->url()
                            ->helperText('Игнорируется при включённом Exely — CTA ведут на /booking'),
                    ]),

                Section::make('Адрес и тексты')
                    ->schema([
                        Locales::text('address', 'Адрес', textarea: true),
                        Locales::json('footer_address', 'Адрес в футере'),
                        Locales::text('reviews', 'Отзывы', textarea: true),
                        Locales::text('copyright', 'Копирайт'),
                        Locales::json('legal', 'Юридическое'),
                    ]),

                Section::make('Часы работы')
                    ->schema([
                        Repeater::make('hours_editor')
                            ->label('Часы работы')
                            ->addActionLabel('Добавить строку')
                            ->reorderable()
                            ->default([])
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        TextInput::make('label_en')->label('Подпись (EN)'),
                                        TextInput::make('label_ru')->label('Подпись (RU)'),
                                        TextInput::make('value_en')->label('Значение (EN)'),
                                        TextInput::make('value_ru')->label('Значение (RU)'),
                                    ]),
                            ]),
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

        $rows = $state['hours_editor'] ?? [];
        unset($state['hours_editor']);

        $hoursEn = [];
        $hoursRu = [];

        foreach ($rows as $row) {
            $hoursEn[] = ['label' => $row['label_en'] ?? '', 'value' => $row['value_en'] ?? ''];
            $hoursRu[] = ['label' => $row['label_ru'] ?? '', 'value' => $row['value_ru'] ?? ''];
        }

        $state['hours'] = ['en' => $hoursEn, 'ru' => $hoursRu];

        $settings = SiteSetting::current();
        $settings->fill($state);
        $settings->save();

        Site::forget();

        Notification::make()
            ->title('Настройки сохранены')
            ->success()
            ->send();
    }

    /**
     * @return array<int, array<string, string>>
     */
    protected function hoursToRows(SiteSetting $settings): array
    {
        $en = $settings->getTranslation('hours', 'en', useFallbackLocale: false) ?? [];
        $ru = $settings->getTranslation('hours', 'ru', useFallbackLocale: false) ?? [];
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
}
