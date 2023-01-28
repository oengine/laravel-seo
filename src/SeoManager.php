<?php

namespace OEngine\Seo;

use Closure;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use OEngine\Seo\Facades\Sitemap;
use OEngine\Seo\Slug\SlugProcess;

class SeoManager
{
    public function Route()
    {
        Route::fallback(SlugProcess::class);
        Route::get('sitemap.xml', function () {
            return response(Sitemap::SitemapIndex(), 200, ['Content-Type' => 'text/xml']);
        })->name('_oengine.sitemap');
        Route::get('{sub}-sitemap-index.xml', function ($sub) {
            return Sitemap::SitemapSubIndex($sub);
        });
        Route::get('{sub}-sitemap.xml', function ($sub) {
            return  response(Sitemap::SitemapDetail($sub), 200, ['Content-Type' => 'text/xml']);
        });
        Route::get('style-sitemap.xsl', function () {
            return response(File::get(__DIR__ . '/../style-sitemap.xsl'), 200, ['Content-Type' => 'text/xml']);
        });
    }
    protected array $tagTransformers = [];

    protected array $SeoInfoTransformers = [];

    public function SeoInfoTransformer(Closure $transformer): static
    {
        $this->SeoInfoTransformers[] = $transformer;

        return $this;
    }

    public function tagTransformer(Closure $transformer): static
    {
        $this->tagTransformers[] = $transformer;

        return $this;
    }

    public function getTagTransformers(): array
    {
        return $this->tagTransformers;
    }

    public function getSeoInfoTransformers(): array
    {
        return $this->SeoInfoTransformers;
    }
}
