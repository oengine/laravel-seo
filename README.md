# Laravel SEO

[![Latest Version on Packagist](https://img.shields.io/packagist/v/oengine/laravel-seo.svg?style=flat-square)](https://packagist.org/packages/oengine/seo)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/oengine/laravel-seo/run-tests?label=tests)](https://github.com/oengine/seo/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/oengine/laravel-seo/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/oengine/laravel-seo/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/oengine/seo.svg?style=flat-square)](https://packagist.org/packages/oengine/seo)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.


## Installation

You can install the package via composer:

```bash
composer require oengine/seo
```
SEO Route:

```php
\OEngine\Seo\Facades\Seo::Route()
```

Support Slug To dynamic view


```php
// url https://oengine.local/abc-xyz-product

class ProductSlug extends \OEngine\Seo\Slug\SlugBase{
    protected $tags = ['product'];
    public function ProcessParams(): self
    {
        $this->format_key_value = false;

        return parent::ProcessParams();
    }
    public function checkSlug()
    {
        return $this->checkParam('product');
    }
    public function formatUrl()
    {
        return '{$product$-product}';
    }
    public function viewSlug()
    {
        return [ProductController,'action'];
    }
}
```


```php
// url https://oengine.local/product-abc-xyz

class ProductSlug extends \OEngine\Seo\Slug\SlugBase{
    protected $tags = ['product'];
    public function ProcessParams(): self
    {
        //default is True
        $this->format_key_value = true;

        return parent::ProcessParams();
    }
    public function checkSlug()
    {
        return $this->checkParam('product');
    }
    public function formatUrl()
    {
        return '{product-$product$}';
    }
    public function viewSlug()
    {
        return [ProductController,'action'];
    }
}
```

```php
// url https://oengine.local/catalog-abc-xyz

class CatalogSlug extends \OEngine\Seo\Slug\SlugBase{
    protected $tags = ['catalog','key1','key2','catalog-parent'];
    public function ProcessParams(): self
    {
        //default is True
        $this->format_key_value = true;

        return parent::ProcessParams();
    }
    public function checkSlug()
    {
        return $this->checkParam('catalog');
    }
    public function formatUrl()
    {
        return '{catalog-$catalog$}';
    }
    public function viewSlug()
    {
        if($this->checkParam('key1')){
            return [CatalogController,'action'];
        }else if($this->checkParam('key2')){ 
            return [CatalogController,'action2'];
        }else{
            //convert catalog,catalog-parent to $catalog,$catalogParent
            return function($catalog,$catalogParent){
                return $catalog
            };
        }
    }
}
```
