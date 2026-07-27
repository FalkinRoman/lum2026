<?php

namespace App\Filament\AvatarProviders;

use Filament\AvatarProviders\Contracts\AvatarProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Stock Heroicons solid user-circle (same as Filament) when no avatar uploaded.
 */
class UserSilhouetteAvatarProvider implements AvatarProvider
{
    public function get(Model | Authenticatable $record): string
    {
        // blade-heroicons/resources/svg/s-user-circle.svg
        $svg = <<<'SVG'
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="12" fill="#e5e7eb"/>
                <path fill="#9ca3af" fill-rule="evenodd" clip-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/>
            </svg>
            SVG;

        return 'data:image/svg+xml;utf8,'.rawurlencode(preg_replace('/\s+/', ' ', trim($svg)) ?? '');
    }
}
