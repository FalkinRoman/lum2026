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

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Site settings';

    protected static ?int $navigationSort = -2;

    protected static ?string $title = 'Site settings';

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
                Section::make('Contacts')
                    ->columns(2)
                    ->schema([
                        TextInput::make('phone')->label('Phone'),
                        TextInput::make('phone_href')->label('Phone href')->helperText('e.g. tel:+79990000000'),
                        TextInput::make('email')->label('Email')->email(),
                        TextInput::make('map_url')->label('Map URL')->url(),
                        TextInput::make('whatsapp_url')->label('WhatsApp URL')->url(),
                        TextInput::make('instagram_url')->label('Instagram URL')->url(),
                        TextInput::make('telegram_url')->label('Telegram URL')->url(),
                        TextInput::make('take_a_break_url')
                            ->label('Take a break URL')
                            ->url()
                            ->helperText('Ignored while Exely is enabled — CTAs go to /booking'),
                        TextInput::make('book_url')
                            ->label('Book URL')
                            ->url()
                            ->helperText('Ignored while Exely is enabled — CTAs go to /booking'),
                    ]),

                Section::make('Address & texts')
                    ->schema([
                        Locales::text('address', 'Address', textarea: true),
                        Locales::json('footer_address', 'Footer address'),
                        Locales::text('reviews', 'Reviews', textarea: true),
                        Locales::text('copyright', 'Copyright'),
                        Locales::json('legal', 'Legal'),
                    ]),

                Section::make('Opening hours')
                    ->schema([
                        Repeater::make('hours_editor')
                            ->label('Hours')
                            ->addActionLabel('Add row')
                            ->reorderable()
                            ->default([])
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        TextInput::make('label_en')->label('Label (EN)'),
                                        TextInput::make('label_ru')->label('Label (RU)'),
                                        TextInput::make('value_en')->label('Value (EN)'),
                                        TextInput::make('value_ru')->label('Value (RU)'),
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
                ->label('Save')
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
            ->title('Settings saved')
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
