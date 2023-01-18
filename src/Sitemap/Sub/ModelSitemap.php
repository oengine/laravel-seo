<?php

namespace OEngine\Seo\Sitemap\Sub;

use OEngine\Seo\Sitemap\SitemapBase;

class ModelSitemap extends SitemapBase
{

    public function __construct($name, $model)
    {
        $this->name = $name;
        $this->model = $model;
    }
    private $name;
    private $model;
    public function getKey()
    {
        return  $this->name;
    }
    public function getPages()
    {
        return [];
    }
    public function getQuery($params): mixed
    {
        return app($this->model)->newQuery();
    }
    public function getData($params)
    {
        return $this->getQuery($params)->orderBy('id', 'desc')->offset(0)
            ->limit(1000)->get()->map(function ($item) {
                return [
                    'url' => $item->getUrl(),
                    'last_update' => $item->getLastUpdate()
                ];
            });
    }
}
