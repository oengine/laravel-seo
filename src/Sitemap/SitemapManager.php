<?php

namespace OEngine\Seo\Sitemap;

use OEngine\Seo\Sitemap\Sub\CallbackSitemap;
use OEngine\Seo\Sitemap\Sub\ModelSitemap;

class SitemapManager
{
	private $arrSitemap = [];
	private $arrSitemapCallback = [];
	private $cacheSitemap = null;

	public function AddSitemap($class, $callback = null)
	{
		if ($callback) {
			$this->arrSitemapCallback[$class] = $callback;
		} else {
			$this->arrSitemap[] = $class;
		}
	}
	protected function getSitemap()
	{
		if ($this->cacheSitemap) return $this->cacheSitemap;
		$sitemam = [];
		foreach ($this->arrSitemapCallback as $key => $item) {
			if (is_callable($item)) {
				$sitemam[$key] = new CallbackSitemap($key, $item);
			} else {
				$sitemam[$key] = new ModelSitemap($key, $item);
			}
		}
		foreach ($this->arrSitemap as $item) {
			$siteItem  = app($item);
			if ($siteItem && method_exists($siteItem, 'getKey')) {
				$sitemam[$siteItem->getKey()] = $siteItem;
			}
		}
		return $this->cacheSitemap = $sitemam;
	}
	public function SitemapIndex()
	{
		$sitemap = $this->getSitemap();
		ob_start();
		echo '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="' . url('style-sitemap.xsl') . '"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		foreach ($sitemap as $key => $item) {
			echo '<sitemap><loc>' . url($key . '-sitemap.xml') . '</loc><lastmod>' . date("Y-m-d\Th:m:s+00:00") . '</lastmod></sitemap>';
		}
		echo '</sitemapindex>
<!-- XML Sitemap generated by OEngine/SEO -->';
		return trim(ob_get_clean());
	}
	public function SitemapSubIndex($sub)
	{
		ob_start();

		return ob_get_clean();
	}
	public function SitemapDetail($sub)
	{
		$sitemap = $this->getSitemap()[$sub];
		ob_start();
		echo '<?xml version="1.0" encoding="UTF-8"?> <?xml-stylesheet type="text/xsl" href="' . url('style-sitemap.xsl') . '"?>
		<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
		';
		if ($sitemap) {
			$data = $sitemap->getData([]);
			foreach ($data as $item) {
				echo '<url><loc>' . $item['url'] . '</loc><lastmod>' . ($item['last_update'] ?? date("Y-m-d\Th:m:s+00:00")) . '</lastmod></url>';
			}
		}

		echo '</urlset>
<!-- XML Sitemap generated by OEngine/SEO -->';
		return trim(ob_get_clean());
	}
}
