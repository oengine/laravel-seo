<?php

namespace OEngine\Seo\Tags;

use OEngine\Seo\SeoInfo;
use OEngine\Seo\Support\Tag;

class TitleTag extends Tag
{
    public string $tag = 'title';

    public function __construct(
        public string $inner,
    ) {
    }

    public static function initialize(?SeoInfo $SeoInfo): Tag|null
    {
        $title = $SeoInfo?->title;

        if (!$title) {
            return null;
        }

        return new static(
            inner: trim($title),
        );
    }
}
