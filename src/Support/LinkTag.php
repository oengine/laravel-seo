<?php

namespace OEngine\Seo\Support;

class LinkTag extends Tag
{
    public string $tag = 'link';

    public function __construct(
        public string $rel,
        public string $href,
    ) {
    }
}
