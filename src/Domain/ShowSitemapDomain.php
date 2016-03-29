<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain;

class ShowSitemapDomain extends ContentDomain
{
    /**
     * Fetches data required to add pages to sitemap.
     *
     * @return array
     */
    public function getPagesData() : array
    {
        $pagesData = [];
        $this->loadPageMeta('slug');
        foreach ($this->pageMeta as $pageMeta) {
            // skip page if slug does not match a route:
            if (!isset($this->config['routes'][$pageMeta['slug']])) {
                continue;
            }
            $lastmod = ($pageMeta['lastmod'] > 0 ) ? $pageMeta['lastmod'] : strtotime($pageMeta['date']);
            array_push($pagesData, [
                'urlPath' => $this->config['routes'][$pageMeta['slug']]['buildPattern'],
                'lastmod' => date('c', $lastmod),
            ]);
        }
        return $pagesData;
    }

    /**
     * Fetches data required to add articles to sitemap.
     *
     * @return array
     */
    public function getArticlesData() : array
    {
        $articlesData = [];
        $this->loadArticleMeta('date');
        krsort($this->articleMeta, SORT_NATURAL);
        $articleRouteBuildPattern = $this->config['routes']['article']['buildPattern'];
        foreach ($this->articleMeta as $articleMeta) {
            $lastmod = ($articleMeta['lastmod'] > 0 ) ? $articleMeta['lastmod'] : strtotime($articleMeta['date']);
            array_push($articlesData, [
                'urlPath' => sprintf($articleRouteBuildPattern, $articleMeta['slug']),
                'lastmod' => date('c', $lastmod),
            ]);
        }
        return $articlesData;
    }

    /**
     * Returns date of latest blog article.
     *
     * @return string
     */
    public function getBlogLastmod() : string
    {
        $this->loadArticleMeta('date');
        krsort($this->articleMeta, SORT_NATURAL);
        if (empty($this->articleMeta)) {
            return '';
        }
        $firstItemData = reset($this->articleMeta);
        return date('c', strtotime($firstItemData['date']));
    }
}
