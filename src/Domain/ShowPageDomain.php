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
        $pageName = trim($uri, '/');
        if (empty($pageName)) {
            $pageName = 'home';
        }
        return $pageName;
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
        $pageContent = $this->parseContentFile($pathToContentFile);
        $page = new PageEntity($this->config);
        $page->setContent($pageContent['content']);
        $page->setMeta($pageContent['meta']);
        return $page;
    }
}
