<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Features\SupportFileUploads\FileUploadConfiguration;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Throwable;

/**
 * Drop-in replacement for Livewire's FileUploadController with:
 * - absolute OR relative signature acceptance (Docker :8080 vs :80)
 * - real error messages instead of opaque "failed to upload" / FilePond "undefined"
 */
class LivewireFileUploadController implements HasMiddleware
{
    public static function middleware(): array
    {
        $middleware = (array) FileUploadConfiguration::middleware();

        if (! in_array('web', $middleware, true)) {
            array_unshift($middleware, 'web');
        }

        return array_map(fn (string $m) => new Middleware($m), $middleware);
    }

    public function handle(Request $request)
    {
        $signatureOk = $request->hasValidSignature(absolute: true)
            || $request->hasValidSignature(absolute: false);

        if (! $signatureOk) {
            Log::warning('Livewire upload rejected: invalid signature', [
                'url' => $request->fullUrl(),
                'host' => $request->getHttpHost(),
                'port' => $request->getPort(),
                'app_url' => config('app.url'),
            ]);

            throw ValidationException::withMessages([
                'files.0' => 'Подпись загрузки невалидна (проверь APP_URL / порт :8080). Обнови страницу и попробуй снова.',
            ]);
        }

        $files = $request->file('files');

        if (empty($files)) {
            throw ValidationException::withMessages([
                'files.0' => 'Файл не получен сервером (пустой multipart).',
            ]);
        }

        try {
            $disk = FileUploadConfiguration::disk();
            $paths = $this->validateAndStore($files, $disk);

            return ['paths' => $paths];
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            report($e);

            Log::error('Livewire upload failed', [
                'message' => $e->getMessage(),
                'disk' => FileUploadConfiguration::disk(),
                'tmp_dir' => FileUploadConfiguration::path(),
                'writable' => is_writable(storage_path('app/private')),
            ]);

            throw ValidationException::withMessages([
                'files.0' => app()->isProduction()
                    ? 'Не удалось сохранить файл. Обновите страницу и попробуйте снова.'
                    : 'Ошибка сохранения: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * @param  array<int, \Illuminate\Http\UploadedFile>  $files
     * @return array<int, string>
     */
    protected function validateAndStore(array $files, string $disk): array
    {
        Validator::make(['files' => $files], [
            'files.*' => FileUploadConfiguration::rules(),
        ])->validate();

        return collect($files)->map(function ($file) use ($disk) {
            $filename = TemporaryUploadedFile::generateHashNameWithOriginalNameEmbedded($file);

            $stored = $file->storeAs('/'.FileUploadConfiguration::path(), $filename, [
                'disk' => $disk,
            ]);

            if ($stored === false || $stored === null || $stored === '') {
                throw new \RuntimeException(
                    app()->isProduction()
                        ? 'Temporary upload write failed.'
                        : "Не удалось записать во временный диск [{$disk}] → ".FileUploadConfiguration::path()
                );
            }

            return str_replace(FileUploadConfiguration::path('/'), '', $stored);
        })->values()->all();
    }
}
