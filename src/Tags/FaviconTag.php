<?php

namespace OEngine\Seo\Tags;

use Illuminate\Support\Collection;
use OEngine\Seo\SeoInfo;
use OEngine\Seo\Support\LinkTag;

class FaviconTag extends LinkTag
{
    public static function initialize(?SeoInfo $SeoInfo): static|null
    {
        $favicon = $SeoInfo?->favicon;

        if (!$favicon) {
            return null;
        }

        return new static(
            rel: 'shortcut icon',
            href: $favicon,
        );
    }

    public function collectAttributes(): Collection
    {
        return parent::collectAttributes()
            ->sortKeys();
    }
}
