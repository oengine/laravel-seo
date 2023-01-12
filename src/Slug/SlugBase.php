<?php

namespace OEngine\Seo\Slug;

use OEngine\Seo\Facades\Slug;

class SlugBase
{
    private $key;
    public function getKey()
    {
        return $this->key ?? ($this->key = (new \ReflectionClass($this))->getShortName());
    }
    private $slug = '';
    private $sort = 0;
    protected $tags = [];
    protected $params = [];
    protected $format_key_value = true;
    public function checkParam($param)
    {
        return isset($this->params[$param]) && $this->params[$param] <> "";
    }
    public function getParams()
    {
        return $this->params ?? [];
    }
    public function ProcessParams(): self
    {
        $tags = isset($this->tags) ? $this->tags : [];
        $this->params = Slug::getParamByDelimiters($this->slug, $tags, $this->format_key_value);
        print_r($this->params);
        return $this;
    }
    public function formatUrl()
    {
        return '';
    }
    public function ToUrl($params = [])
    {
        $url = $this->formatUrl();
        preg_match_all('/{[^}]*}/', $url, $varParams, PREG_PATTERN_ORDER);
        $varParams = $varParams[0];
        return  collect($varParams)->map(function ($item) use ($params) {
            foreach ($params as $key => $value) {
                $item =  str_replace('$' . $key . '$', $value, $item);
            }
            return str_replace('{', '', str_replace('}', '', $item));
        })->join('-');
    }
    public function __construct($slug, $sort = -1)
    {
        $this->slug = $slug;
        $this->sort = $sort;
    }
    public function getSort()
    {
        return $this->sort;
    }
    public function checkSlug()
    {
        return true;
    }
    public function viewSlug()
    {
        return view('404');
    }
}
