<?php

namespace OEngine\Seo\Tags\Meta;

use OEngine\Seo\Tags\Tag;

class MetaTag extends Tag
{
    public string $tag = 'meta';

    public function __construct(
        public string $name,
        public string $content,
    ) {
    }
}
