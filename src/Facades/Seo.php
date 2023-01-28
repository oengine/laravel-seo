<?php

namespace OEngine\Seo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * 
 * @method static mixed Route()
 * @method static mixed SeoInfoTransformer(Closure $transformer)
 * @method static mixed tagTransformer(Closure $transformer)
 * @method static mixed getTagTransformers()
 * @method static mixed getSeoInfoTransformers()
 *
 * @see \OEngine\Seo\Facades\Seo
 */
class Seo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \OEngine\Seo\SeoManager::class;
    }
}
