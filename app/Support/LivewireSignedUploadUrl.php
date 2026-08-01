<?php

namespace App\Support;

use Illuminate\Support\Facades\URL;
use Livewire\Features\SupportFileUploads\FileUploadConfiguration;
use Livewire\Features\SupportFileUploads\GenerateSignedUploadUrl;

/**
 * Relative signed upload URLs avoid APP_URL/:8080 vs nginx:80 signature mismatches.
 */
class LivewireSignedUploadUrl extends GenerateSignedUploadUrl
{
    public function forLocal()
    {
        return URL::temporarySignedRoute(
            'livewire.upload-file',
            now()->addMinutes(FileUploadConfiguration::maxUploadTime()),
            absolute: false,
        );
    }
}
