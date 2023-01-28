<?php

namespace OEngine\Seo\Tags\TwitterCard;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use OEngine\Seo\SeoInfo;
use OEngine\Seo\Support\TwitterCardTag;
use OEngine\Seo\Traits\RenderableCollection;

class SummaryLargeImage extends Collection implements Renderable
{
    use RenderableCollection;

    public static function initialize(SeoInfo $SeoInfo): static
    {
        $collection = new static();

        if ($SeoInfo->imageMeta) {
            if ($SeoInfo->imageMeta->width < 300) {
                return $collection;
            }

            if ($SeoInfo->imageMeta->height < 157) {
                return $collection;
            }

            if ($SeoInfo->imageMeta->width > 4096) {
                return $collection;
            }

            if ($SeoInfo->imageMeta->height > 4096) {
                return $collection;
            }
        }

        $collection->push(new TwitterCardTag('card', 'summary_large_image'));

        if ($SeoInfo->image) {
            $collection->push(new TwitterCardTag('image', $SeoInfo->image));

            if ($SeoInfo->imageMeta) {
                $collection
                    ->when($SeoInfo->imageMeta?->width, fn (self $collection): self => $collection->push(new TwitterCardTag('image:width', $SeoInfo->imageMeta->width)))
                    ->when($SeoInfo->imageMeta?->height, fn (self $collection): self => $collection->push(new TwitterCardTag('image:height', $SeoInfo->imageMeta->height)));
            }
        }

        return $collection;
    }
}
