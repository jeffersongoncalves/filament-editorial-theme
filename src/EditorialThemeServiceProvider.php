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
}
