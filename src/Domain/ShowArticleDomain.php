<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain;

use Nekudo\ShinyBlog\Exception\NotFoundException;
use Nekudo\ShinyBlog\Domain\Entity\ArticleEntity;

class ShowArticleDomain extends ContentDomain
{
    /**
     * Loads article data by given slug.
     *
     * @param string $slug
     * @throws NotFoundException
     * @return ArticleEntity
     */
    public function getArticleBySlug(string $slug) : ArticleEntity
    {
        $this->loadArticleMeta('slug');
        if (!isset($this->articleMeta[$slug])) {
            throw new NotFoundException('Sry. The requested article seems to be lost in space.');
        }
        $articleData = $this->parseContentFile($this->articleMeta[$slug]['file']);
        $article = new ArticleEntity($this->config, $articleData);
        return $article;
    }

    /**
     * Returns index/follow setting for article page.
     *
     * @return string
     */
    public function getIndex() : string
    {
        return $this->config['seo']['article']['index'];
    }
}
