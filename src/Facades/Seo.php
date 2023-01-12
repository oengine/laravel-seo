<?php

namespace OEngine\Seo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * 
 * @method static mixed Route()
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
