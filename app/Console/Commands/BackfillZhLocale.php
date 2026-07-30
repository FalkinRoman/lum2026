<?php

namespace App\Console\Commands;

use Database\Seeders\CmsContentSeeder;
use Illuminate\Console\Command;

class BackfillZhLocale extends Command
{
    protected $signature = 'cms:backfill-zh';

    protected $description = 'Backfill Chinese (zh) CMS translations from lang/zh without wiping media';

    public function handle(): int
    {
        $this->components->info('Backfilling zh translations from lang/zh/lum.php…');

        (new CmsContentSeeder)->backfillZhOnly();

        $this->components->info('Done. en/ru locales and media paths were not modified.');

        return self::SUCCESS;
    }
}
