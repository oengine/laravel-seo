<?php

namespace OEngine\Seo;

use Carbon\Carbon;

class SeoInfo
{
    public function __construct(
        public ?string $title = null,
        public ?string $description = null,
        public ?string $author = null,
        public ?string $image = null,
        public ?string $url = null,
        public bool $enableTitleSuffix = true,
        public ?Carbon $published_time = null,
        public ?Carbon $modified_time = null,
        public ?string $section = null,
        public ?array $tags = null,
        public ?string $twitter_username = null,
        public ?string $type = 'website',
        public ?string $site_name = null,
        public ?string $favicon = null,
    ) {
    }
}
