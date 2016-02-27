<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain;

use DirectoryIterator;
use Nekudo\ShinyBlog\Exception\NotFoundException;
use RuntimeException;
use Nekudo\ShinyBlog\Domain\Entity\ArticleEntity;

class ShowArticleDomain extends ContentDomain
{
    protected $articleData = [];

    /**
     * Loads article data by given slug.
     *
     * @param string $slug
     * @throws NotFoundException
     * @return ArticleEntity
     */
    public function getArticleBySlug(string $slug) : ArticleEntity
    {
        $this->loadArticleData('slug');
        if (!isset($this->articleData[$slug])) {
            throw new NotFoundException('Article not found.');
        }
        $articleData = $this->articleData[$slug];
        $this->parseMarkdownOfContent($articleData);
        $article = new ArticleEntity;
        $article->setContent($articleData['content']);
        $article->setMeta($articleData['meta']);
        return $article;
    }

    /**
     * Loads all articles.
     *
     * @param string $keyName The key to use in article data array.
     */
    protected function loadArticleData(string $keyName)
    {
        $pathToArticleContents = $this->config['contentsFolder'] . 'articles/';
        if (!is_dir($pathToArticleContents)) {
            throw new RuntimeException('Articles folder not found.');
        }
        $iterator = new DirectoryIterator($pathToArticleContents);
        foreach ($iterator as $file) {
            if ($file->isDot()) {
                continue;
            }
            if ($file->getExtension() !== 'md') {
                continue;
            }
            $articleData = $this->parseContentFile($file->getPathname(), false);
            if (empty($articleData['meta'][$keyName])) {
                throw new RuntimeException('Key not found in article meta.');
            }
            $key = $articleData['meta'][$keyName];
            $this->articleData[$key] = $articleData;
        }
    }
}