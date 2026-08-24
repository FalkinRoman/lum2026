<?php

namespace App\Console\Commands;

use App\Support\LumImageOptimizer;
use Illuminate\Console\Command;

class OptimizeLumImagesCommand extends Command
{
    protected $signature = 'lum:optimize-images {--edge=1600 : Max edge length for WebP derivatives}';

    protected $description = 'Build WebP display derivatives for oversized CMS images under public/images/lum';

    public function handle(): int
    {
        $edge = max(320, (int) $this->option('edge'));

        $this->info("Warming Lum image derivatives (max edge {$edge}px)...");

        $stats = LumImageOptimizer::warmAll($edge);

        $this->line("Scanned: {$stats['scanned']}");
        $this->line("Built/refreshed: {$stats['built']}");
        $this->line("Skipped (already small): {$stats['skipped']}");
        $this->line("Failed: {$stats['failed']}");

        return $stats['failed'] > 0 ? self::FAILURE : self::SUCCESS;
    }
}
