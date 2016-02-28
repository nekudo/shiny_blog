<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain;

use Nekudo\ShinyBlog\Exception\NotFoundException;

class ShowBlogDomain extends ContentDomain
{
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
     * @throws NotFoundException
     * @return array
     */
    public function getArticles(int $page = 0) : array
    {
        $this->loadArticleMeta('date');
        krsort($this->articleMeta, SORT_NATURAL);
        $this->articleCount = count($this->articleMeta);

        // check if page number is valid:
        if ($this->pageIsValid($page) === false) {
            throw new NotFoundException('Invalid page number.');
        }

        // convert page to start/end index:
        $limit = $this->config['pagination']['limit'];
        $start = ($page > 0) ? ($page - 1) * $limit : 0;
        $end = ($start + $limit) - 1;
        $end = ($end > $this->articleCount) ? $this->articleCount - 1 : $end;

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
        $pages = ceil($this->articleCount / $limit);
        if ($page > $pages || $page < 0) {
            return false;
        }
        return true;
    }
}