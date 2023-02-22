<?php

use Illuminate\Database\Eloquent\Model;
use OEngine\Seo\Facades\Slug;
use OEngine\Seo\SeoInfo;
use OEngine\Seo\Support\Pipe\Pipe;
use OEngine\Seo\Tags\TagManager;

if (!function_exists('SlugToUrl')) {
    function SlugToUrl($slug = '', $params = [])
    {
        return Slug::ToUrl($slug, $params);
    }
}

if (!function_exists('pipe')) {
    function pipe(mixed $passable = null): Pipe
    {
        return $passable ? app(Pipe::class)->send($passable) : app(Pipe::class);
    }
}


if (!function_exists('seo')) {
    function seo(Model|SeoInfo $source = null): TagManager
    {
        $tagManager = app(TagManager::class);

        if ($source) {
            $tagManager->for($source);
        }

        return $tagManager;
    }
}
