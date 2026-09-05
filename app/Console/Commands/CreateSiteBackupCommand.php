<?php

namespace App\Console\Commands;

use App\Support\SiteBackup;
use Illuminate\Console\Command;
use Throwable;

class CreateSiteBackupCommand extends Command
{
    protected $signature = 'lum:backup
                            {--db-only : Snapshot only the SQLite DB, skipping ~370 MB of uploads}
                            {--prune= : Keep only the newest N backups of this kind (0 = do not prune)}';

    protected $description = 'Create a ZIP backup of the SQLite CMS DB, optionally with admin uploads';

    public function handle(): int
    {
        $dbOnly = (bool) $this->option('db-only');

        $this->info($dbOnly
            ? 'Creating database-only backup…'
            : 'Creating full content backup (database + uploads)…');

        try {
            $backup = SiteBackup::create(withUploads: ! $dbOnly);
        } catch (Throwable $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        $mb = number_format($backup['size'] / 1048576, 2);
        $this->info("Created {$backup['name']} ({$mb} MB)");
        $this->line($backup['path']);

        // Each kind keeps its own history, so daily DB runs never evict weekly full backups.
        $default = $dbOnly ? SiteBackup::KEEP_DB : SiteBackup::KEEP_FULL;
        $prune = $this->option('prune') === null ? $default : (int) $this->option('prune');

        if ($prune > 0) {
            $removed = SiteBackup::prune($prune, $backup['kind']);
            if ($removed > 0) {
                $this->info("Pruned {$removed} old {$backup['kind']} backup(s); keeping newest {$prune}.");
            }
        }

        return self::SUCCESS;
    }
}
