<?php

namespace OEngine\Seo\Tags;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use OEngine\Seo\SeoInfo;
use OEngine\Seo\Support\SitemapTag as SitemapTagSupport;
use OEngine\Seo\Traits\RenderableCollection;

class SitemapTag extends Collection implements Renderable
{
    use RenderableCollection;

    public static function initialize(SeoInfo $SeoInfo = null): static
    {
        $collection = new static();

        if ($sitemap = config('seo.sitemap')) {
            if (!is_string($sitemap)) $sitemap = $sitemap();
            $collection->push(new SitemapTagSupport($sitemap));
        }

        return $collection;
    }
}
