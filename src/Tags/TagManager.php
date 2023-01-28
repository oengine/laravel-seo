<?php

namespace OEngine\Seo\Tags;


use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use OEngine\Seo\Facades\Seo;
use OEngine\Seo\SeoInfo;

class TagManager implements Renderable
{
    public Model $model;

    public SeoInfo $SeoInfo;

    public TagCollection $tags;

    public function __construct()
    {
        $this->tags = TagCollection::initialize(
            $this->fillSeoInfo()
        );
    }

    public function fillSeoInfo(SeoInfo $SeoInfo = null): SeoInfo
    {
        $SeoInfo ??= new SeoInfo();

        $defaults = [
            'title' => config('seo.title.infer_title_from_url') ? $this->inferTitleFromUrl() : null,
            'description' => config('seo.description.fallback'),
            'image' => config('seo.image.fallback'),
            'site_name' => config('seo.site_name'),
            'author' => config('seo.author.fallback'),
            'twitter_username' => Str::of(config('seo.twitter.@username'))->start('@'),
            'favicon' => config('seo.favicon'),
        ];

        foreach ($defaults as $property => $defaultValue) {
            if ($SeoInfo->{$property} === null) {
                $SeoInfo->{$property} = $defaultValue;
            }
        }

        if ($SeoInfo->enableTitleSuffix) {
            $SeoInfo->title .= config('seo.title.suffix');
        }

        if ($SeoInfo->image && !filter_var($SeoInfo->image, FILTER_VALIDATE_URL)) {
            $SeoInfo->imageMeta();

            $SeoInfo->image = secure_url($SeoInfo->image);
        }

        if ($SeoInfo->favicon && !filter_var($SeoInfo->favicon, FILTER_VALIDATE_URL)) {
            $SeoInfo->favicon = secure_url($SeoInfo->favicon);
        }

        if (!$SeoInfo->url) {
            $SeoInfo->url = url()->current();
        }

        if ($SeoInfo->url === url('/') && ($homepageTitle = config('seo.title.homepage_title'))) {
            $SeoInfo->title = $homepageTitle;
        }

        return $SeoInfo->pipethrough(
            Seo::getSeoInfoTransformers()
        );
    }

    public function for(Model|SeoInfo $source): static
    {
        if ($source instanceof Model) {
            $this->model = $source;
            unset($this->SeoInfo);
        } elseif ($source instanceof SeoInfo) {
            unset($this->model);
            $this->SeoInfo = $source;
        }

        // The tags collection is already initialized when constructing the manager. Here, we'll
        // initialize the collection again, but this time we pass the model to the initializer.
        // The initializes will pass the generated SeoInfo to all underlying initializers, ensuring that
        // the tags are always fully up-to-date and no remnants from previous initializations are present.
        $SeoInfo = isset($this->model)
            ? $this->model->seo?->prepareForUsage()
            : $this->SeoInfo;

        $this->tags = TagCollection::initialize(
            $this->fillSeoInfo($SeoInfo ?? new SeoInfo())
        );

        return $this;
    }

    protected function inferTitleFromUrl(): string
    {
        return Str::of(url()->current())
            ->afterLast('/')
            ->headline();
    }

    public function render(): string
    {
        return $this->tags
            ->pipeThrough(Seo::getTagTransformers())
            ->reduce(function (string $carry, Renderable $item) {
                return $carry .= Str::of($item->render())->trim() . PHP_EOL;
            }, '');
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
