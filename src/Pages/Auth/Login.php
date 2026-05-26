<?php

namespace JeffersonGoncalves\FilamentEditorialTheme\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;

class Login extends BaseLogin
{
    protected string $view = 'filament-editorial-theme::auth.login';

    public function getHeading(): string
    {
        return '';
    }

    public function getSubheading(): ?string
    {
        return null;
    }

    public function hasLogo(): bool
    {
        return false;
    }
}
