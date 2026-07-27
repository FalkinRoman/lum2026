<?php

namespace App\Filament\Pages;

use App\Filament\Forms\Locales;
use App\Models\SiteSetting;
use App\Support\Site;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManagePrivacyPolicy extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static string|UnitEnum|null $navigationGroup = 'Настройки';

    protected static ?string $navigationLabel = 'Политика конфиденциальности';

    protected static ?int $navigationSort = 92;

    protected static ?string $title = 'Политика конфиденциальности';

    protected string $view = 'filament.pages.manage-site-settings';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $settings = SiteSetting::current();

        $this->form->fill([
            'privacy_title' => [
                'en' => $settings->getTranslation('privacy_title', 'en', useFallbackLocale: false),
                'ru' => $settings->getTranslation('privacy_title', 'ru', useFallbackLocale: false),
            ],
            'privacy_body' => [
                'en' => $settings->getTranslation('privacy_body', 'en', useFallbackLocale: false),
                'ru' => $settings->getTranslation('privacy_body', 'ru', useFallbackLocale: false),
            ],
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Текст страницы /privacy')
                    ->description('EN и RU. Пустая строка между абзацами = новый параграф на сайте.')
                    ->schema([
                        Locales::text('privacy_title', 'Заголовок'),
                        Locales::text('privacy_body', 'Текст', textarea: true, rows: 20),
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
        $settings = SiteSetting::current();
        $settings->fill($this->form->getState());
        $settings->save();
        Site::forget();

        Notification::make()->title('Политика сохранена')->success()->send();
    }
}
