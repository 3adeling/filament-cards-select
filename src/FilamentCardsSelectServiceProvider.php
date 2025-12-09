<?php

namespace Adelali\FilamentCardsSelect;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentCardsSelectServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-cards-select';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews();
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            Css::make('filament-cards-select', __DIR__.'/../resources/dist/filament-cards-select.css'),
        ], 'adelali/filament-cards-select');
    }
}
