<x-filament-panels::page>
    <div class="space-y-4">
        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="fi-section-content-ctn p-6 text-sm text-gray-600 dark:text-gray-300 space-y-2">
                <p>
                    Бэкап = <strong>база контента</strong> (тексты, настройки, виллы, пользователи)
                    + <strong>картинки из админки</strong>.
                    Это не весь исходный код сайта — код хранится в репозитории.
                </p>
                <p>
                    На сервере бэкап также создаётся автоматически раз в сутки (cron).
                    Скачивать после каждой правки в админке <strong>не обязательно</strong> —
                    достаточно периодически сохранять свежий архив себе на компьютер
                    (раз в неделю / перед крупными правками).
                </p>
            </div>
        </div>

        @if (count($this->backups) === 0)
            <div class="rounded-xl bg-white p-6 text-sm text-gray-500 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 dark:text-gray-400">
                Пока нет бэкапов. Нажмите «Создать бэкап сейчас».
            </div>
        @else
            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3 font-medium">Файл</th>
                            <th class="px-4 py-3 font-medium">Дата</th>
                            <th class="px-4 py-3 font-medium">Размер</th>
                            <th class="px-4 py-3 font-medium text-right">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/10">
                        @foreach ($this->backups as $backup)
                            <tr wire:key="backup-{{ $backup['name'] }}">
                                <td class="px-4 py-3 font-mono text-xs text-gray-800 dark:text-gray-200">
                                    {{ $backup['name'] }}
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
                                    {{ $backup['date_label'] }}
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
                                    {{ $backup['size_label'] }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-2">
                                        <x-filament::button
                                            tag="button"
                                            size="sm"
                                            color="gray"
                                            wire:click="download('{{ $backup['name'] }}')"
                                        >
                                            Скачать
                                        </x-filament::button>
                                        <x-filament::button
                                            tag="button"
                                            size="sm"
                                            color="danger"
                                            wire:click="deleteBackup('{{ $backup['name'] }}')"
                                            wire:confirm="Удалить этот бэкап?"
                                        >
                                            Удалить
                                        </x-filament::button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-filament-panels::page>
