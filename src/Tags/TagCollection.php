<?php

namespace OEngine\Seo\Tags;

use Closure;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use OEngine\Seo\SeoInfo;
use OEngine\Seo\Support\SchemaTagCollection;

class TagCollection extends Collection
{
    public static function initialize(SeoInfo $SeoInfo = null): static
    {
        $collection = new static();

        $tags = collect([
            RobotsTag::initialize($SeoInfo),
            CanonicalTag::initialize($SeoInfo),
            SitemapTag::initialize($SeoInfo),
            DescriptionTag::initialize($SeoInfo),
            AuthorTag::initialize($SeoInfo),
            TitleTag::initialize($SeoInfo),
            ImageTag::initialize($SeoInfo),
            FaviconTag::initialize($SeoInfo),
            OpenGraphTags::initialize($SeoInfo),
            TwitterCardTags::initialize($SeoInfo),
            SchemaTagCollection::initialize($SeoInfo, $SeoInfo->schema),
        ])->reject(fn (?Renderable $item): bool => $item === null);

        foreach ($tags as $tag) {
            $collection->push($tag);
        }

        return $collection;
    }
}
