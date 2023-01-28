<?php

namespace OEngine\Seo\Tags;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use OEngine\Seo\SeoInfo;
use OEngine\Seo\Support\TwitterCardTag;
use OEngine\Seo\Tags\TwitterCard\Summary;
use OEngine\Seo\Tags\TwitterCard\SummaryLargeImage;
use OEngine\Seo\Traits\RenderableCollection;

class TwitterCardTags extends Collection implements Renderable
{
    use RenderableCollection;

    public static function initialize(SeoInfo $SeoInfo): ?static
    {
        $collection = new static();

        // No generic image that spans multiple pages
        if ( $SeoInfo->image && $SeoInfo->image !== secure_url(config('seo.image.fallback')) ) {
            if ( $SeoInfo->imageMeta?->width - $SeoInfo->imageMeta?->height - 20 < 0 ) {
                $collection->push(Summary::initialize($SeoInfo));
            }

            if ( $SeoInfo->imageMeta?->width - 2 * $SeoInfo->imageMeta?->height - 20 < 0 ) {
                $collection->push(SummaryLargeImage::initialize($SeoInfo));
            }
        } else {
            $collection->push(new TwitterCardTag('card', 'summary'));
        }

        if ( $SeoInfo->title ) {
            $collection->push(new TwitterCardTag('title', $SeoInfo->title));
        }

        if ( $SeoInfo->description ) {
            $collection->push(new TwitterCardTag('description', $SeoInfo->description));
        }

        if ( $SeoInfo->twitter_username && $SeoInfo->twitter_username !== '@' ) {
            $collection->push(new TwitterCardTag('site', $SeoInfo->twitter_username));
        }

        return $collection;
    }
}