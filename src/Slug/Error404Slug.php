<?php

namespace OEngine\Seo\Slug;

class Error404Slug extends SlugBase
{
    public function getSort()
    {
        return 1000000000000000;
    }
    public function checkSlug()
    {
        return true;
    }
    public function viewSlug()
    {
        return abort(404);
    }
}
