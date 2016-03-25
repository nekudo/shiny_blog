<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Action;

use Nekudo\ShinyBlog\Domain\ShowSitemapDomain;
use Nekudo\ShinyBlog\Responder\ShowSitemapResponder;

class ShowSitemapAction extends BaseAction
{
    /** @var ShowSitemapDomain $domain */
    protected $domain;

    /** @var ShowSitemapResponder $responder */
    protected $responder;

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->domain = new ShowSitemapDomain($config);
        $this->responder = new ShowSitemapResponder($config);
    }

    /**
     * Collect sitemap elements and render sitemap.
     *
     * @param array $arguments
     */
    public function __invoke(array $arguments)
    {
        $this->addBlogToSitemap();
        $this->addArticlesToSitemap();
        $this->addPagesToSitemap();
        $this->responder->__invoke();
    }

    /**
     * Adds blog page to sitemap.
     */
    protected function addBlogToSitemap()
    {
        $urlPath = $this->config['routes']['blog']['buildPattern'];
        $lastmod = $this->domain->getBlogLastmod();
        $this->responder->addBlogItem($urlPath, $lastmod);
    }

    /**
     * Adds article items to sitemap.
     *
     * @return bool
     */
    protected function addArticlesToSitemap() : bool
    {
        $articlesData = $this->domain->getArticlesData();
        if (empty($articlesData)) {
            return false;
        }
        foreach ($articlesData as $itemData) {
            $this->responder->addArticleItem($itemData['urlPath'], $itemData['lastmod']);
        }
        return true;
    }

    /**
     * Adds page items to sitemap.
     *
     * @return bool
     */
    protected function addPagesToSitemap() : bool
    {
        $pagesData = $this->domain->getPagesData();
        if (empty($pagesData)) {
            return false;
        }
        foreach ($pagesData as $itemData) {
            $this->responder->addPageItem($itemData['urlPath'], $itemData['lastmod']);
        }
        return true;
    }
}
