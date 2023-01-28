<?php

namespace OEngine\Seo\Tags;

use OEngine\Seo\SeoInfo;
use OEngine\Seo\Support\MetaTag;

class ImageTag extends MetaTag
{
    public static function initialize(?SeoInfo $SeoInfo): MetaTag|null
    {
        $image = $SeoInfo?->image;

        if (!$image) {
            return null;
        }

        return new MetaTag(
            name: 'image',
            content: trim($image)
        );
    }
}
