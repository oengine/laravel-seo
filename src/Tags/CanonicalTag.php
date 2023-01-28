<?php

namespace OEngine\Seo\Tags;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use OEngine\Seo\SeoInfo;
use OEngine\Seo\Support\LinkTag;
use OEngine\Seo\Traits\RenderableCollection;

class CanonicalTag extends Collection implements Renderable
{
    use RenderableCollection;

    public static function initialize(SeoInfo $SeoInfo = null): static
    {
        $collection = new static();

        if (config('seo.canonical_link')) {
            $collection->push(new LinkTag('canonical', $SeoInfo->url));
        }

        return $collection;
    }
}
