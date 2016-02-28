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
    public function getArticles(int $page = 0) : array
    {
        $this->loadArticleMeta('date');
        $this->articleCount = count($this->articleMeta);
        krsort($this->articleMeta, SORT_NATURAL);

        // convert page to start/end index:
        $limit = $limit = $this->config['pagination']['limit'];
        $start = ($page > 0) ? ($page - 1) * $limit : 0;
        $end = ($start + $limit) - 1;
        $end = ($end > $this->articleCount) ? $this->articleCount - 1 : $end;

        // get articles:
        $articles = $this->getArticlesFromMeta($start, $end);
        return $articles;
    }
}