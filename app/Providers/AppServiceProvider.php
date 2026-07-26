<?php

namespace App\Providers;

use App\Support\Site;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($url = config('app.url')) {
            URL::forceRootUrl(rtrim($url, '/'));
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
