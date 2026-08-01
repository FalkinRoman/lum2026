<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Livewire\Features\SupportFileUploads\FileUploadConfiguration;

class DiagnoseUploadsCommand extends Command
{
    protected $signature = 'lum:diagnose-uploads';

    protected $description = 'Check Livewire/Filament upload prerequisites on this host';

    public function handle(): int
    {
        $disk = FileUploadConfiguration::disk();
        $path = FileUploadConfiguration::path();
        $root = storage_path('app/private');
        $tmp = $root.'/'.$path;

        $this->line('APP_URL='.config('app.url'));
        $this->line('APP_HOST='.config('app.host').' APP_PORT='.config('app.port'));
        $this->line('GD='.(extension_loaded('gd') ? 'yes' : 'NO'));
        $this->line("livewire disk={$disk} path={$path}");
        $this->line('storage/app/private writable='.(is_writable($root) ? 'yes' : 'NO'));
        $this->line('tmp dir exists='.(is_dir($tmp) ? 'yes' : 'no'));
        $this->line('tmp dir writable='.(is_writable($tmp) || (! is_dir($tmp) && is_writable($root)) ? 'yes' : 'NO'));

        try {
            $probe = $path.'/__probe_'.uniqid('', true).'.txt';
            Storage::disk($disk)->put($probe, 'ok');
            $ok = Storage::disk($disk)->get($probe) === 'ok';
            Storage::disk($disk)->delete($probe);
            $this->line('write probe='.($ok ? 'ok' : 'FAIL'));
        } catch (\Throwable $e) {
            $this->error('write probe failed: '.$e->getMessage());
        }

        $abs = URL::temporarySignedRoute('livewire.upload-file', now()->addMinutes(5));
        $rel = URL::temporarySignedRoute('livewire.upload-file', now()->addMinutes(5), absolute: false);
        $this->line('signed abs='.$abs);
        $this->line('signed rel='.$rel);

        return self::SUCCESS;
    }
}
