<?php

namespace OEngine\Seo;

use Illuminate\Support\Facades\Route;
use OEngine\Seo\Slug\SlugProcess;

class SeoManager
{
    public function Route()
    {
        Route::fallback(SlugProcess::class);
    }
}
