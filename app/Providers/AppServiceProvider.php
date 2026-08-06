<?php

namespace App\Providers;

use App\Http\Responses\FilamentLoginResponse;
use App\Support\LivewireSignedUploadUrl;
use App\Support\Site;
use Filament\Auth\Http\Responses\Contracts\LoginResponse as FilamentLoginResponseContract;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Livewire\Features\SupportFileUploads\GenerateSignedUploadUrl;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Relative signed upload URLs — survive Docker host:8080 ↔ nginx:80 mismatch.
        $this->app->singleton(GenerateSignedUploadUrl::class, LivewireSignedUploadUrl::class);

        // Path-only post-login redirect so the browser keeps :8080.
        $this->app->singleton(FilamentLoginResponseContract::class, FilamentLoginResponse::class);
    }

    public function boot(): void
    {
        $url = (string) config('app.url');
        $host = (string) config('app.host');
        $port = (string) config('app.port');
        $scheme = (string) config('app.scheme', 'http');

        // Prefer explicit host:port so Filament redirects keep :8080 even when
        // the request hits nginx inside the container on port 80.
        if ($host !== '') {
            $url = in_array($port, ['', '80', '443'], true)
                ? sprintf('%s://%s', $scheme, $host)
                : sprintf('%s://%s:%s', $scheme, $host, $port);
        }

        if ($url !== '') {
            URL::forceRootUrl(rtrim($url, '/'));
        }

        if ($scheme === 'https') {
            URL::forceScheme('https');
        }

        if (config('database.default') === 'sqlite') {
            try {
                DB::statement('PRAGMA journal_mode=WAL;');
                DB::statement('PRAGMA synchronous=NORMAL;');
                DB::statement('PRAGMA foreign_keys=ON;');
            } catch (\Throwable) {
                // DB may not be ready during early boot / package discovery.
            }
        }

        View::composer(['lum.partials.*', 'components.lum.*', 'layouts.lum'], function ($view) {
            $view->with('siteSettings', Site::settings());
        });

        Blade::directive('siteTakeBreak', fn () => '<?php echo e(\\App\\Support\\Site::takeABreakUrl()); ?>');
        Blade::directive('siteMap', fn () => '<?php echo e(\\App\\Support\\Site::mapUrl()); ?>');
        Blade::directive('sitePhoneHref', fn () => '<?php echo e(\\App\\Support\\Site::phoneHref()); ?>');
        Blade::directive('siteEmailHref', fn () => '<?php echo e(\\App\\Support\\Site::emailHref()); ?>');
        Blade::directive('siteBook', fn () => '<?php echo e(\\App\\Support\\Site::bookUrl()); ?>');
    }
}
