<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain;

use Nekudo\ShinyBlog\Domain\Traits\SlugableTrait;
use Nekudo\ShinyBlog\Domain\Traits\CategoryFilterTrait;
use Nekudo\ShinyBlog\Exception\NotFoundException;

class ShowBlogDomain extends ContentDomain
{
    use SlugableTrait;
    use CategoryFilterTrait;

    /** @var int $articleCount */
    protected $articleCount = 0;

    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    /**
     * Fetches a list of articles ordered by date.
     *
     * @param int $page
     * @param string $categorySlug
     * @throws NotFoundException
     * @return array
     */
    public function getArticles(int $page = 0, string $categorySlug = '') : array
    {
        $this->loadArticleMeta('date');
        if (!empty($categorySlug)) {
            $this->filterArticlesByCategorySlug($categorySlug);
        }
        krsort($this->articleMeta, SORT_NATURAL);
        $this->articleCount = count($this->articleMeta);

        // throw 404 for empty categories:
        if ($this->articleCount === 0 && !empty($categorySlug)) {
            throw new NotFoundException('Category not found');
        }

        // check if page number is valid:
        if ($this->pageIsValid($page) === false) {
            throw new NotFoundException('Invalid page number.');
        }

        // convert page to start/end index:
        $limit = $this->config['pagination']['limit'];
        $start = ($page > 0) ? ($page - 1) * $limit : 0;
        $end = ($start + $limit) - 1;
        $end = ($end >= $this->articleCount) ? $this->articleCount - 1 : $end;

        // get articles:
        $articles = $this->getArticlesFromMeta($start, $end);
        return $articles;
    }

    /**
     * Checks if requested page is valid.
     *
     * @param int $page
     * @return bool
     */
    protected function pageIsValid(int $page) : bool
    {
        $limit = $this->config['pagination']['limit'];
        $pages = (int) ceil($this->articleCount / $limit);
        if ($page > $pages || $page < 0) {
            return false;
        }
        return true;
    }

    /**
     * Returns URL to previous page. Will be empty if already on first page.
     *
     * @param int $page
     * @param string $category
     * @return string
     */
    public function getUrlPrevPage(int $page, string $category = '') : string
    {
        if ($page <= 1) {
            return '';
        }
        $prevPage = $page - 1;
        $pageType = (!empty($category)) ? 'category' : 'blog';
        if ($prevPage > 1) {
            $pageType .= '_paginated';
        }
        $buildPattern = $this->config['routes'][$pageType]['buildPattern'];
        if ($pageType === 'category' || $pageType === 'category_paginated') {
            return sprintf($buildPattern, $category, $prevPage);
        }
        return sprintf($buildPattern, $prevPage);
    }

    /**
     * Returns URL to next page. Will be empty if already in last page.
     *
     * @param int $page
     * @param string $category
     * @return string
     */
    public function getUrlNextPage(int $page, string $category = '') : string
    {
        if ($page === 0) {
            $page = 1;
        }
        $limit = $this->config['pagination']['limit'];
        $pages = (int) ceil($this->articleCount / $limit);
        if ($page >= $pages) {
            return '';
        }
        $nextPage = $page + 1;
        $pageType = (!empty($category)) ? 'category' : 'blog';
        $pageType .= '_paginated';
        $buildPattern = $this->config['routes'][$pageType]['buildPattern'];
        if ($pageType === 'category_paginated') {
            return sprintf($buildPattern, $category, $nextPage);
        }
        return sprintf($buildPattern, $nextPage);
    }

    /**
     * Returns blog title formatted as defined in config.
     *
     * @param int $page
     * @param string $category
     * @return string
     */
    public function getTitle(int $page, string $category = '') : string
    {
        $pageType = (!empty($category)) ? 'category' : 'blog';
        if ($page > 1) {
            $pageType .= '_paginated';
        }
        $seoConfig = $this->config['seo'][$pageType];
        return sprintf($seoConfig['title'], $page);
    }

    /**
     * Returns blog meta-description formatted as defined in config.
     *
     * @param int $page
     * @param string $category
     * @return string
     */
    public function getDescription(int $page, string $category = '') : string
    {
        $pageType = (!empty($category)) ? 'category' : 'blog';
        if ($page > 1) {
            $pageType .= '_paginated';
        }
        $seoConfig = $this->config['seo'][$pageType];
        return sprintf($seoConfig['description'], $page);
    }

    /**
     * Get index,follow setting for blog page.
     *
     * @param int $page
     * @param string $category
     * @return string
     */
    public function getIndex(int $page, string $category = '') : string
    {
        $pageType = (!empty($category)) ? 'category' : 'blog';
        if ($page > 1) {
            $pageType .= '_paginated';
        }
        $seoConfig = $this->config['seo'][$pageType];
        return $seoConfig['index'];
    }
}
