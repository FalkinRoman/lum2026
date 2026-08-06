<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Facades\Filament;

class Login extends BaseLogin
{
    public function mount(): void
    {
        if (Filament::auth()->check()) {
            // Path-only — keep browser on :8080 (Docker nginx is :80 internally).
            $this->redirect($this->panelHomePath());

            return;
        }

        $this->form->fill();
    }

    protected function panelHomePath(): string
    {
        $path = '/'.ltrim((string) (Filament::getCurrentPanel()?->getPath() ?? 'admin'), '/');

        return $path === '/' ? '/admin' : $path;
    }
}
