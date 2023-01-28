<?php

namespace OEngine\Seo\Tags;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use OEngine\Seo\SeoInfo;
use OEngine\Seo\Support\MetaContentTag;
use OEngine\Seo\Support\OpenGraphTag;
use OEngine\Seo\Traits\RenderableCollection;

class OpenGraphTags extends Collection implements Renderable
{
    use RenderableCollection;

    public static function initialize(SeoInfo $SeoInfo): static
    {
        $collection = new static();

        if ($SeoInfo->title) {
            $collection->push(new OpenGraphTag('title', $SeoInfo->title));
        }

        if ($SeoInfo->description) {
            $collection->push(new OpenGraphTag('description', $SeoInfo->description));
        }

        if ($SeoInfo->locale) {
            $collection->push(new OpenGraphTag('locale', $SeoInfo->locale));
        }

        if ($SeoInfo->image) {
            $collection->push(new OpenGraphTag('image', $SeoInfo->image));

            if ($SeoInfo->imageMeta) {
                $collection
                    ->when($SeoInfo->imageMeta->width, fn (self $collection): self => $collection->push(new OpenGraphTag('image:width', $SeoInfo->imageMeta->width)))
                    ->when($SeoInfo->imageMeta->height, fn (self $collection): self => $collection->push(new OpenGraphTag('image:height', $SeoInfo->imageMeta->height)));
            }
        }

        $collection->push(new OpenGraphTag('url', $SeoInfo->url));

        if ($SeoInfo->site_name) {
            $collection->push(new OpenGraphTag('site_name', $SeoInfo->site_name));
        }

        if ($SeoInfo->type) {
            $collection->push(new OpenGraphTag('type', $SeoInfo->type));
        }

        if ($SeoInfo->published_time && $SeoInfo->type === 'article') {
            $collection->push(new MetaContentTag('article:published_time', $SeoInfo->published_time->toIso8601String()));
        }

        if ($SeoInfo->modified_time && $SeoInfo->type === 'article') {
            $collection->push(new MetaContentTag('article:modified_time', $SeoInfo->modified_time->toIso8601String()));
        }

        if ($SeoInfo->section && $SeoInfo->type === 'article') {
            $collection->push(new MetaContentTag('article:section', $SeoInfo->section));
        }

        if ($SeoInfo->tags && $SeoInfo->type === 'article') {
            foreach ($SeoInfo->tags as $tag) {
                $collection->push(new MetaContentTag('article:tag', $tag));
            }
        }

        return $collection;
    }
}
