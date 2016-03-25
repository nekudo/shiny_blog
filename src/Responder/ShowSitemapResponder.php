<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Responder;

use SimpleXMLElement;

class ShowSitemapResponder extends HttpResponder
{
    /**
     * @var array $items Holds items to be listed in sitemap.
     */
    protected $items = [];

    public function __invoke()
    {
        $this->setHeader();
        $sitemapXml = $this->renderSitemap();
        $this->found($sitemapXml);
    }

    /**
     * Adds blog-url to sitemap.
     *
     * @param string $urlPath
     * @param string $lastmod
     */
    public function addBlogItem(string $urlPath, string $lastmod)
    {
        $settings = $this->config['sitemap']['blog'];
        $this->addItem($urlPath, $lastmod, $settings['changefreq'], $settings['priority']);
    }

    /**
     * Adds article-url to sitemap.
     *
     * @param string $urlPath
     * @param string $lastmod
     */
    public function addArticleItem(string $urlPath, string $lastmod)
    {
        $settings = $this->config['sitemap']['article'];
        $this->addItem($urlPath, $lastmod, $settings['changefreq'], $settings['priority']);
    }

    /**
     * Adds page-url to sitemap.
     *
     * @param string $urlPath
     * @param string $lastmod
     */
    public function addPageItem(string $urlPath, string $lastmod)
    {
        $settings = $this->config['sitemap']['page'];
        $this->addItem($urlPath, $lastmod, $settings['changefreq'], $settings['priority']);
    }

    /**
     * Adds new url/item to sitemap.
     *
     * @param string $urlPath
     * @param string $lastmod
     * @param string $changefreq
     * @param string $priority
     */
    public function addItem(string $urlPath, string $lastmod, string $changefreq, string $priority)
    {
        array_push($this->items, [
            'loc' => $this->getUrlFromPath($urlPath),
            'lastmod' => $lastmod,
            'changefreq' => $changefreq,
            'priority' => $priority
        ]);
    }

    /**
     * Sets XML header.
     */
    protected function setHeader()
    {
        header('Content-Type: text/xml', true);
    }

    /**
     * Renders sitemap items to XML.
     *
     * @return string
     */
    protected function renderSitemap() : string
    {
        $urlset = new SimpleXMLElement(
            '<?xml version="1.0" encoding="UTF-8" ?>
                <urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" 
                        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
            LIBXML_NOERROR|LIBXML_ERR_NONE|LIBXML_ERR_FATAL
        );

        // add urls:
        foreach ($this->items as $itemData) {
            $url = $urlset->addChild('url');
            $url->addChild('loc', $itemData['loc']);
            $url->addChild('lastmod', $itemData['lastmod']);
            $url->addChild('changefreq', $itemData['changefreq']);
            $url->addChild('priority', $itemData['priority']);
        }

        // return xml:
        return $urlset->asXML();
    }
}
