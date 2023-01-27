<?php

namespace OEngine\Seo;

use Illuminate\Support\ServiceProvider;
use OEngine\LaravelPackage\ServicePackage;
use OEngine\LaravelPackage\WithServiceProvider;

class SeoServiceProvider extends ServiceProvider
{
    use WithServiceProvider;
    public function configurePackage(ServicePackage $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         */
        $package
            ->name('laravel-seo')
            ->hasConfigFile()
            ->hasViews()
            ->hasHelpers()
            ->hasAssets()
            ->hasTranslations()
            ->runsMigrations();
    }
}
