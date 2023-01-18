<?php

namespace OEngine\Seo;

use Illuminate\Support\ServiceProvider;
use OEngine\Seo\Facades\Sitemap;

class SeoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Sitemap::AddSitemap('product', function () {
            return [];
        });
        Sitemap::AddSitemap('catalog', function () {
            return [
                ['url' => url('thong-tin-moi'), 'last_update' => date("Y-m-d\Th:m:s+00:00")],
                ['url' => url('thong-tin-moi2'), 'last_update' => date("Y-m-d\Th:m:s+00:00")],
                ['url' => url('thong-tin-moi4'), 'last_update' => date("Y-m-d\Th:m:s+00:00")]
            ];
        });
    }
}
