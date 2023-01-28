<?php

namespace OEngine\Seo\Support;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;

abstract class Tag implements Renderable
{
    protected static array $reservedAttributes = [
        'tag',
        'inner',
        'attributesPipeline',
    ];

    public string $tag;

    public array $attributesPipeline = [];

    public function render()
    {

        ob_start();
        echo '<' . $this->tag . ' ';
        foreach ($this->collectAttributes() as $key => $value) {
            echo $key .= '="' . $value . '" ';
        }
        if (isset($this->inner) && $this->inner) {
            echo '>';
            echo $this->inner;
            echo '</' . $this->tag . '>';
        } else {
            echo '/>';
        }

        return  trim(ob_get_clean());
    }

    public function collectAttributes(): Collection
    {
        return collect($this->attributes ?? get_object_vars($this))
            ->except(static::$reservedAttributes)
            ->pipe(function (Collection $attributes) {
                $reservedAttributes = $attributes->only('property', 'name', 'rel');

                return $reservedAttributes->merge($attributes->except('property', 'name', 'rel')->sortKeys());
            })
            ->pipeThrough($this->attributesPipeline);
    }
}
