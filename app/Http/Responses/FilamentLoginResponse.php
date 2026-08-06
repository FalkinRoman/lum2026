<?php

namespace App\Http\Responses;

use Filament\Auth\Http\Responses\Contracts\LoginResponse as Responsable;
use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

/**
 * Always redirect with a path-only URL so the browser keeps :8080.
 * Absolute URLs generated inside Docker (nginx :80) often drop the public port.
 */
class FilamentLoginResponse implements Responsable
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        $fallback = $this->panelPath();

        $intended = session()->pull('url.intended');

        if (is_string($intended) && $intended !== '') {
            $path = parse_url($intended, PHP_URL_PATH) ?: $fallback;
            $query = parse_url($intended, PHP_URL_QUERY);

            // Only follow intended targets inside this panel.
            if (is_string($path) && str_starts_with($path, $fallback)) {
                return redirect()->to($path.($query ? '?'.$query : ''));
            }
        }

        return redirect()->to($fallback);
    }

    protected function panelPath(): string
    {
        $path = '/'.ltrim((string) (Filament::getCurrentPanel()?->getPath() ?? 'admin'), '/');

        return $path === '/' ? '/admin' : $path;
    }
}
