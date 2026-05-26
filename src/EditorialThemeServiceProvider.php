<?php

namespace JeffersonGoncalves\FilamentEditorialTheme;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class EditorialThemeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-editorial-theme')
            ->hasConfigFile('filament-editorial-theme')
            ->hasViews('filament-editorial-theme')
            ->hasTranslations();
    }

    public function packageRegistered(): void
    {
        $this->publishes([
            __DIR__ . '/../stubs/theme.css.stub' => resource_path('css/filament/admin/theme.css'),
        ], 'filament-editorial-theme-stubs');

        $this->publishes([
            __DIR__ . '/../resources/fonts' => resource_path('fonts/editorial'),
        ], 'filament-editorial-theme-fonts');

        $this->publishes([
            __DIR__ . '/../resources/css/theme.css' => resource_path('css/vendor/filament-editorial-theme/theme.css'),
        ], 'filament-editorial-theme-css');
    }
}
