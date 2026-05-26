<?php

namespace JeffersonGoncalves\FilamentEditorialTheme\Concerns;

/**
 * Mixin for Filament Login pages to swap in the editorial terminal view.
 *
 * Uses Livewire's bootTraitName convention to override the static $view
 * property at runtime — declaring $view directly on the trait collides
 * with the SimplePage/Page parent property.
 *
 * Usage:
 *
 *   class Login extends \Filament\Auth\Pages\Login
 *   {
 *       use \JeffersonGoncalves\FilamentEditorialTheme\Concerns\HasTerminalLogin;
 *   }
 */
trait HasTerminalLogin
{
    public function bootHasTerminalLogin(): void
    {
        static::$view = 'filament-editorial-theme::auth.login';
    }
}
