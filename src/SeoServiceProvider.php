<?php

namespace OEngine\Seo;

use Illuminate\Support\ServiceProvider;
use OEngine\LaravelPackage\ServicePackage;
use OEngine\LaravelPackage\WithServiceProvider;
use OEngine\Seo\Facades\Seo;

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
    public function packageBooted()
    {
        if (function_exists('platform_by')) {
            Seo::Route();
        }
    }
}
