<?php

namespace OEngine\Seo\Slug;

use OEngine\Seo\Facades\Slug;

class SlugProcess
{
    public function __invoke($slug)
    {
        return Slug::ViewBySlug($slug);
    }
}
