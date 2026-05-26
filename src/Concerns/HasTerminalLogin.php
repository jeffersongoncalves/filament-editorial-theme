<?php

namespace JeffersonGoncalves\FilamentEditorialTheme\Concerns;

/**
 * Mixin for Filament Login pages to swap in the editorial terminal view.
 *
 * Usage in a custom Login page:
 *
 *   class Login extends \Filament\Auth\Pages\Login
 *   {
 *       use \JeffersonGoncalves\FilamentEditorialTheme\Concerns\HasTerminalLogin;
 *   }
 */
trait HasTerminalLogin
{
    protected static string $view = 'filament-editorial-theme::auth.login';
}
