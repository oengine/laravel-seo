<?php

namespace OEngine\Seo\Sitemap\Sub;

use OEngine\Seo\Sitemap\SitemapBase;

class CallbackSitemap extends SitemapBase
{
    public function __construct($name, $callback)
    {
        $this->name = $name;
        $this->callback = $callback;
    }
    private $name;
    private $callback;
    public function getKey()
    {
        $this->name;
    }
    public function getPages()
    {
        return [];
    }
    public function getData($params)
    {
        $callback = $this->callback;
        if ($callback) return $callback($params);
        return [];
    }
}
