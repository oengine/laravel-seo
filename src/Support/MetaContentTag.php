<?php

namespace OEngine\Seo\Support;

class MetaContentTag extends Tag
{
    public string $tag = 'meta';

    public function __construct(
        public string $property,
        public string $content,
    ) {}
}