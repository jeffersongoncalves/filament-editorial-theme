<?php

namespace JeffersonGoncalves\FilamentEditorialTheme\Pages\Auth;

class Login extends \Filament\Auth\Pages\Login
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
