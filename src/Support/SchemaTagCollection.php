<?php

namespace OEngine\Seo\Support;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use OEngine\Seo\Schemas\SchemaCollection;
use OEngine\Seo\SeoInfo;
use OEngine\Seo\Traits\RenderableCollection;

class SchemaTagCollection extends Collection implements Renderable
{
    use RenderableCollection;

    public static function initialize(SeoInfo $SeoInfo, SchemaCollection $schema = null): ?static
    {
        $collection = new static();

        if (!$schema) {
            return null;
        }

        foreach ($schema->markup as $markupClass => $markupBuilders) {
            $collection = $collection->push(new $markupClass($SeoInfo, $markupBuilders));
        }

        return $collection;
    }
}
