<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain;

class ShowBlogDomain extends ContentDomain
{
    /** @var int $articleCount */
    protected $articleCount = 0;

    /**
     * Fetches a list of articles ordered by date.
     *
     * @param int $page
     * @return array
     */
    public function getArticles(int $page) : array
    {
        $this->loadArticleMeta('date');
        $this->articleCount = count($this->articleMeta);
        krsort($this->articleMeta, SORT_NATURAL);
        $articles = $this->getArticlesFromMeta($this->config['pagination']['limit']);
        return $articles;
    }
}