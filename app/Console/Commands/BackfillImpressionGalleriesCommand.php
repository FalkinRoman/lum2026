<?php

namespace App\Console\Commands;

use App\Models\Activity;
use App\Models\Excursion;
use App\Support\ImpressionGalleries;
use Illuminate\Console\Command;

class BackfillImpressionGalleriesCommand extends Command
{
    protected $signature = 'lum:backfill-impression-galleries {--dry-run : Show what would change}';

    protected $description = 'Fill empty impression_galleries on activities/excursions from lang defaults';

    public function handle(): int
    {
        $dry = (bool) $this->option('dry-run');
        $updated = 0;

        foreach (Excursion::query()->get() as $excursion) {
            if (! ImpressionGalleries::isEmpty($excursion->impression_galleries)) {
                continue;
            }

            $this->line("excursion:{$excursion->slug}");
            if (! $dry) {
                $excursion->impression_galleries = ImpressionGalleries::forExcursion();
                $excursion->save();
            }
            $updated++;
        }

        foreach (Activity::query()->get() as $activity) {
            if (! ImpressionGalleries::isEmpty($activity->impression_galleries)) {
                continue;
            }

            $this->line("activity:{$activity->slug}");
            if (! $dry) {
                $activity->impression_galleries = ImpressionGalleries::forActivity();
                $activity->save();
            }
            $updated++;
        }

        $this->info(($dry ? 'Would update' : 'Updated').": {$updated}");

        return self::SUCCESS;
    }
}
