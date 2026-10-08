<?php

namespace JeffersonGoncalves\FilamentEditorialTheme\Pages\Auth;

use Illuminate\Contracts\Support\Htmlable;

class Login extends \Filament\Pages\Auth\Login
{
    protected static string $view = 'filament-editorial-theme::auth.login';

    public function getHeading(): string|Htmlable
    {
        return '';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return null;
    }

    public function hasLogo(): bool
    {
        return false;
    }
}
