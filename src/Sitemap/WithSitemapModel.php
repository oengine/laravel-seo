<?php

namespace OEngine\Seo\Sitemap;

trait WithSitemapModel
{
    public function getUrl()
    {
    }
    public function getTitle()
    {
    }
    public function getLastUpdate()
    {
    }
    public function getPriority()
    {
        return 0.2;
    }
    public function getChangeFrequency()
    {
        return 'Monthly';
    }
}
