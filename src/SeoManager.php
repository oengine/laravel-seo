<?php

namespace OEngine\Seo;

use Illuminate\Support\Facades\Route;

class SeoManager
{
    public function Route()
    {
        Route::fallback(SlugProcess::class);
    }
}
