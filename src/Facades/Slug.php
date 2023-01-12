<?php

namespace OEngine\SEO\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * 
 * @method static mixed getParamByDelimiters(string $slug,array $delimiters,bool $format_key_value)
 * @method static mixed ViewBySlug(string $slug)
 * @method static array getParameters()
 * @method static string ToUrl($slugName, $params)
 * @method static mixed getParameter($name, $default = null)
 *
 * @see \OEngine\SEO\Facades\Slug
 */
class Slug extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \OEngine\SEO\Slug\SlugManager::class;
    }
}
