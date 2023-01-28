<?php

namespace OEngine\Seo\Schemas;

use Closure;
use Illuminate\Support\Collection;
use OEngine\Seo\Support\Pipe\Pipeable;
use OEngine\Seo\SeoInfo;
use OEngine\Seo\Support\Tag;

abstract class Schema extends Tag
{
    use Pipeable;

    public array $attributes = [
        'type' => 'application/ld+json',
    ];

    public string $context = 'https://schema.org/';

    public Collection $markup;

    public array $markupTransformers = [];

    public string $tag = 'script';

    public function __construct(SeoInfo $SeoInfo, array $markupBuilders = [])
    {
        $this->initializeMarkup($SeoInfo, $markupBuilders);

        $this->pipeThrough($markupBuilders);

        $this->inner = $this->generateInner();
    }

    abstract public function generateInner(): string;

    abstract public function initializeMarkup(SeoInfo $SeoInfo, array $markupBuilders): void;

    public function markup(Closure $transformer): static
    {
        $this->markupTransformers[] = $transformer;

        return $this;
    }
}
