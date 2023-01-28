<?php

namespace OEngine\Seo;

use Carbon\Carbon;
use Illuminate\Support\Str;
use OEngine\Seo\Schemas\SchemaCollection;
use OEngine\Seo\Support\Pipe\Pipeable;

class SeoInfo
{
    use Pipeable;
    public function __construct(
        public ?string $title = null,
        public ?string $description = null,
        public ?SchemaCollection $schema = null,
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
        public ?string $locale = null,
        public ?string $robots = null,
        public ?ImageMeta $imageMeta = null,
    ) {
        if ($this->locale === null) {
            $this->locale = Str::of(app()->getLocale())->lower()->kebab();
        }
    }

    public function imageMeta(): ?ImageMeta
    {
        if ($this->image) {
            return $this->imageMeta ??= new ImageMeta($this->image);
        }

        return null;
    }

    public function markAsNoindex(): static
    {
        $this->robots = 'noindex, nofollow';

        return $this;
    }
}
