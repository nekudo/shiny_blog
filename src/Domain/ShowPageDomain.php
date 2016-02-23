<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain;

use Nekudo\ShinyBlog\Domain\Entity\PageEntity;

class ShowPageDomain extends ContentDomain
{
    /**
     * Generates pages filename from current request URI.
     *
     * @return string
     */
    public function getPageFilename() : string
    {
        $uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $pageName = trim($uri, '/');
        if (empty($pageName)) {
            $pageName = 'home';
        }
        return $pageName . '.md';
    }

    public function getPageByFilename(string $filename) : PageEntity
    {
        $pagedataPath = $this->config['contentsFolder'] . 'pages/' . $filename;
        $pageContent = $this->parseContentFile($pagedataPath);
        $page = new PageEntity;
        $page->setContent($pageContent['content']);
        $page->setMeta($pageContent['meta']);
        return $page;
    }

    /**
     * Retrieves page content from pages markdown file.
     *
     * @param string $pageName
     * @return array
     */
    public function getPageContent(string $pageName) : array
    {
        $contentPath = $this->config['contentsFolder'] . 'pages/' . $pageName . '.md';
        $pageContent = $this->parseContentFile($contentPath);
        return $pageContent;
    }
}
