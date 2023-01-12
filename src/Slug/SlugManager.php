<?php

namespace OEngine\Seo\Slug;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ItemNotFoundException;

class SlugManager
{
    public function __construct()
    {
        //$this->AddSlug(Error404Slug::class);
    }
    public function getParamByDelimiters($slug, $delimiters, $format_key_value = true)
    {
        if (!$delimiters || !is_array($delimiters) || count($delimiters) == 0) return [];
        $delimitersIndex = [];
        foreach ($delimiters as $key) {
            if (str_starts_with($slug, $key)) {
                $delimitersIndex[] = ['sort' => 0, 'key' => $key];;
            }
            $index = 1;
            while ($index = strpos($slug, $key, $index)) {
                $delimitersIndex[] = ['sort' => $index, 'key' => $key];
                $index++;
            }
        }
        usort($delimitersIndex, function ($a, $b) {
            if ($a['sort'] == $b['sort']) {
                return 0;
            }
            return ($a['sort'] < $b['sort']) ? -1 : 1;
        });
        $newStr = str_replace($delimiters, $delimiters[0], $slug);
        $params = explode($delimiters[0], $newStr);
        if ($format_key_value) {
            array_shift($params);
        }
        $lenParam = count($delimitersIndex);
        $keyValues = [];
        for ($i = 0; $i <  $lenParam; $i++) {
            $key =  $delimitersIndex[$i]['key'];
            $value = trim(trim($params[$i], '-'));
            if (isset($keyValues[$key])) {
                if (is_array($keyValues[$key])) {
                    $keyValues[$key] = [...$keyValues[$key], $value];
                } else {
                    $keyValues[$key] = [$keyValues[$key], $value];
                }
            } else {
                $keyValues[$key] = $value;
            }
        }
        return $keyValues;
    }
    public function ToUrl($slugName, $params)
    {
        $slug = $this->getSlugByKey($slugName);
        if (!$slug) throw new ItemNotFoundException($slugName . ' is not found slug');
        // return '';
        return $slug->ToUrl($params);
    }
    private $keySlugs = [];
    private $arrSlug = [];
    public function getSlugByKey($key)
    {
        if (count($this->keySlugs) == 0 && count($this->arrSlug) > 0) {
            $arrSlug = $this->arrSlug;
            $index = -1;
            $slug = '';
            $arrSlugs = array_map(function ($item) use ($slug, $index) {
                $index++;
                return  new $item($slug, $index);
            },  $arrSlug);
            usort($arrSlugs, function ($a, $b) {
                return strcmp($a->getSort(), $b->getSort());
            });
            /** @var \OEngine\Core\Support\Slug\SlugBase  */
            foreach ($arrSlugs as $item) {
                $this->keySlugs[$item->getKey()] = $item;
                $this->keySlugs[str($item->getKey())->kebab()->toString()] = $item;
            }
        }
        // print_r(array_keys($this->keySlugs));
        return isset($this->keySlugs[$key]) && $this->keySlugs[$key] != '' ? $this->keySlugs[$key] : null;
    }
    public function AddSlug($class)
    {
        $this->arrSlug[] = $class;
    }
    public function ViewBySlug($slug)
    {
        $arrSlug = $this->arrSlug;
        $index = -1;
        $arrSlugs = array_map(function ($item) use ($slug, $index) {
            $index++;
            return  new $item($slug, $index);
        },  $arrSlug);
        usort($arrSlugs, function ($a, $b) {
            return strcmp($a->getSort(), $b->getSort());
        });
        $pageSlug = null;
        /** @var \OEngine\Seo\Slug\SlugBase  */
        foreach ($arrSlugs as $item) {
            if ($pageSlug == null && $item->ProcessParams()->checkSlug()) {
                $request = request();
                $route = Route::addRoute('get', '/', $item->viewSlug())->setContainer(app())->bind($request);
                foreach ($item->getParams() as $paramKey => $paramValue) {
                    $paramKey =  str($paramKey)->camel()->toString();
                    $route->setParameter($paramKey, $paramValue);
                }
                $request->setRouteResolver(function () use ($route) {
                    return $route;
                });
                $pageSlug =  $route->run();
            }
            $this->keySlugs[$item->getKey()] = $item;
            $this->keySlugs[str($item->getKey())->kebab()->toString()] = $item;
        }
        return  $pageSlug ?? abort(404);
    }
}
