<?php

namespace App\Filament\Pages;

use App\Support\SiteBackup;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Number;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;
use UnitEnum;

class ManageBackups extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBox;

    protected static string|UnitEnum|null $navigationGroup = 'Настройки';

    protected static ?string $navigationLabel = 'Бэкапы';

    protected static ?int $navigationSort = 95;

    protected static ?string $title = 'Бэкапы контента';

    protected string $view = 'filament.pages.manage-backups';

    /**
     * @return list<array{name: string, path: string, size: int, modified_at: int, size_label: string, date_label: string}>
     */
    public function getBackupsProperty(): array
    {
        return array_map(static function (array $item): array {
            $item['size_label'] = Number::fileSize($item['size']);
            $item['date_label'] = date('d.m.Y H:i', $item['modified_at']);

            return $item;
        }, SiteBackup::list());
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->label('Создать бэкап сейчас')
                ->icon(Heroicon::OutlinedPlus)
                ->color('primary')
                ->requiresConfirmation()
                ->modalHeading('Создать бэкап?')
                ->modalDescription('В архив попадут база CMS (SQLite) и все картинки, загруженные через админку. Код сайта в архив не входит — он в git.')
                ->action(function (): void {
                    try {
                        $backup = SiteBackup::create();
                        SiteBackup::prune(SiteBackup::KEEP_FULL, SiteBackup::KIND_FULL);

                        Notification::make()
                            ->title('Бэкап создан')
                            ->body($backup['name'].' · '.Number::fileSize($backup['size']))
                            ->success()
                            ->send();
                    } catch (Throwable $e) {
                        report($e);

                        Notification::make()
                            ->title('Не удалось создать бэкап')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }

    public function download(string $name): BinaryFileResponse
    {
        $path = SiteBackup::path($name);

        return response()->download($path, $name, [
            'Content-Type' => 'application/zip',
        ]);
    }

    public function deleteBackup(string $name): void
    {
        try {
            SiteBackup::delete($name);

            Notification::make()
                ->title('Бэкап удалён')
                ->success()
                ->send();
        } catch (Throwable $e) {
            Notification::make()
                ->title('Не удалось удалить')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
