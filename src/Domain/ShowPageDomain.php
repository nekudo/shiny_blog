<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain;

use Nekudo\ShinyBlog\Domain\Entity\PageEntity;

class ShowPageDomain extends ContentDomain
{
    /**
     * Fetches page alias from current request URI.
     *
     * @return string
     */
    public function getPageSlug() : string
    {
        $uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $pathParts = explode('/', trim($uri, '/'));
        $pageSlug = array_pop($pathParts);
        if (empty($pageSlug)) {
            $pageSlug = 'home';
        }
        return $pageSlug;
    }

    /**
     * Renders content from pages markdown file and returns page object.
     *
     * @param string $slug
     * @return PageEntity
     */
    public function getPageBySlug(string $slug) : PageEntity
    {
        $pathToContentFile = $this->config['contentsFolder'] . 'pages/' . $slug . '.md';
        $pageData = $this->parseContentFile($pathToContentFile);
        $page = new PageEntity($this->config, $pageData);
        return $page;
    }

    /**
     * Fetches index/follow setting for pages.
     *
     * @return string
     */
    public function getIndex() : string
    {
        return $this->config['seo']['page']['index'];
    }
}
