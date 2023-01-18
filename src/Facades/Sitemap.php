<?php

namespace OEngine\Seo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * 
 * @method static mixed AddSitemap($name)
 * @method static mixed AddSitemap($name,$callback)
 * @method static mixed SitemapIndex()
 * @method static mixed SitemapSubIndex($sub)
 * @method static mixed SitemapDetail($sub)
 *
 * @see \OEngine\Seo\Facades\Sitemap
 */
class Sitemap extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \OEngine\Seo\Sitemap\SitemapManager::class;
    }
}
