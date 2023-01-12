<?php

use OEngine\SEO\Facades\Slug;

if (!function_exists('SlugToUrl')) {
    function SlugToUrl($slug = '', $params)
    {
        return Slug::ToUrl($slug, $params);
    }
}
