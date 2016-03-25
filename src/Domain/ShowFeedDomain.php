<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain;

use Nekudo\ShinyBlog\Domain\Traits\CategoryFilterTrait;
use Nekudo\ShinyBlog\Domain\Traits\SlugableTrait;
use Nekudo\ShinyBlog\Exception\NotFoundException;

class ShowFeedDomain extends ContentDomain
{
    use SlugableTrait;
    use CategoryFilterTrait;

    /** @var int $articleCount */
    protected $articleCount = 0;

    /**
     * Fetches a list of articles ordered by date.
     *
     * @param int $limit
     * @param string $categorySlug
     * @throws NotFoundException
     * @return array
     */
    public function getArticles(int $limit = 0, string $categorySlug = '') : array
    {
        $this->loadArticleMeta('date');
        if (!empty($categorySlug)) {
            $this->filterArticlesByCategorySlug($categorySlug);
        }
        krsort($this->articleMeta, SORT_NATURAL);
        $this->articleCount = count($this->articleMeta);

        // throw 404 for empty categories:
        if ($this->articleCount === 0 && !empty($categorySlug)) {
            throw new NotFoundException('Invalid Feed Request. Pleas check URL.');
        }

        if ($limit >= $this->articleCount) {
            $limit = $this->articleCount - 1;
        }

        // get articles:
        $articles = $this->getArticlesFromMeta(0, $limit);
        return $articles;
    }

    /**
     * Returns url path to feed.
     *
     * @param string $categorySlug If set path to category path will be returned.
     * @return string
     */
    public function getFeedUrlPath(string $categorySlug = '') : string
    {
        if (!empty($categorySlug)) {
            $buildPattern = $this->config['routes']['category_feed']['buildPattern'];
            $path = sprintf($buildPattern, $categorySlug);
        } else {
            $path = $this->config['routes']['feed']['buildPattern'];
        }
        return $path;
    }
}
