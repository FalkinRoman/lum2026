<?php

namespace App\Console\Commands;

use App\Support\SiteBackup;
use Illuminate\Console\Command;
use Throwable;

class CreateSiteBackupCommand extends Command
{
    protected $signature = 'lum:backup
                            {--prune=14 : Keep only the newest N backups (0 = do not prune)}';

    protected $description = 'Create a ZIP backup of SQLite CMS DB + admin uploads';

    public function handle(): int
    {
        $this->info('Creating site content backup…');

        try {
            $backup = SiteBackup::create();
        } catch (Throwable $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        $mb = number_format($backup['size'] / 1048576, 2);
        $this->info("Created {$backup['name']} ({$mb} MB)");
        $this->line($backup['path']);

        $prune = (int) $this->option('prune');

        if ($prune > 0) {
            $removed = SiteBackup::prune($prune);
            if ($removed > 0) {
                $this->info("Pruned {$removed} old backup(s); keeping newest {$prune}.");
            }
        }

        return self::SUCCESS;
    }
}
