<?php

namespace OEngine\Seo\Tags;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use OEngine\Seo\SeoInfo;
use OEngine\Seo\Support\MetaTag;
use OEngine\Seo\Traits\RenderableCollection;

class RobotsTag extends Collection implements Renderable
{
    use RenderableCollection;

    public static function initialize(SeoInfo $SeoInfo = null): static
    {
        $collection = new static();

        $robotsContent = config('seo.robots.default');

        if (!config('seo.robots.force_default')) {
            $robotsContent = $SeoInfo?->robots ?? $robotsContent;
        }

        $collection->push(new MetaTag('robots', $robotsContent));

        return $collection;
    }
}
