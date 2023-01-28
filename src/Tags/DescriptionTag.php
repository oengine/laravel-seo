<?php

namespace OEngine\Seo\Tags;

use OEngine\Seo\SeoInfo;
use OEngine\Seo\Support\MetaTag;

class DescriptionTag extends MetaTag
{
    public static function initialize(?SeoInfo $SeoInfo): MetaTag|null
    {
        $description = $SeoInfo?->description;

        if (!$description) {
            return null;
        }

        return new MetaTag(
            name: 'description',
            content: trim($description)
        );
    }
}
