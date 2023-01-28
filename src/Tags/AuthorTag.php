<?php

namespace OEngine\Seo\Tags;

use OEngine\Seo\SeoInfo;
use OEngine\Seo\Support\MetaTag;

class AuthorTag extends MetaTag
{
    public static function initialize(?SeoInfo $SeoInfo): MetaTag|null
    {
        $author = $SeoInfo?->author;

        if (!$author) {
            return null;
        }

        return new MetaTag(
            name: 'author',
            content: trim($author)
        );
    }
}
