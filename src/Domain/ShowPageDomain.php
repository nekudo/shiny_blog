<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain;

class ShowPageDomain extends ContentDomain
{
    /**
     * Extracts page name from current request URI.
     *
     * @return string
     */
    public function getPageName() : string
    {
        $uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $pageName = trim($uri, '/');
        if (empty($pageName)) {
            $pageName = 'home';
        }
        return $pageName;
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
