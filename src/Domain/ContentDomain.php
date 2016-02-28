<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain;

use DirectoryIterator;
use Nekudo\ShinyBlog\Domain\Entity\ArticleEntity;
use RuntimeException;
use ParsedownExtra;

class ContentDomain extends BaseDomain
{
    /** @var string $contentRaw */
    protected $contentRaw = '';

    /** @var ParsedownExtra $markdownParser */
    protected $markdownParser;

    protected $articleData = [];

    protected $articleMeta = [];

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->markdownParser = new ParsedownExtra;
    }

    /**
     * Loads metadata of articles.
     *
     * @param string $keyName Key to use as array index.
     */
    protected function loadArticleMeta(string $keyName)
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
            $articleMeta = $articleData['meta'];
            if (empty($articleMeta[$keyName])) {
                throw new RuntimeException('Key not found in article meta.');
            }
            $key = $articleMeta[$keyName];
            $this->articleMeta[$key] = $articleMeta;
            $this->articleMeta[$key]['file'] = $file->getPathname();
        }
    }

    /**
     * Loads articles from set of metadata.
     *
     * @param int $limit
     * @return array
     */
    protected function getArticlesFromMeta(int $limit) : array
    {
        $articles = [];
        if (empty($this->articleMeta)) {
            return $articles;
        }
        $cnt = 0;
        foreach ($this->articleMeta as $meta) {
            $articleContent = $this->parseContentFile($meta['file']);
            $article = new ArticleEntity;
            $article->setMeta($articleContent['meta']);
            $article->setContent($articleContent['content']);
            array_push($articles, $article);
            $cnt++;
            if ($cnt === $limit) {
                break;
            }
        }
        return $articles;
    }



    /**
     * Parses a content-file and splits data into a meta and content section.
     *
     * @param string $pathToFile
     * @param bool $includeContent
     * @return array
     */
    public function parseContentFile(string $pathToFile, bool $includeContent = true) : array
    {
        if (!file_exists($pathToFile)) {
            throw new RuntimeException('Page content not found');
        }
        $this->contentRaw = file_get_contents($pathToFile);
        if (empty($this->contentRaw)) {
            throw new RuntimeException('Invalid content file.');
        }
        if (strpos($this->contentRaw, '::METAEND::') === false) {
            throw new RuntimeException('Invalid content file.');
        }

        $content = [];
        $sections = explode('::METAEND::', $this->contentRaw);
        $content['meta'] = json_decode($sections[0], true);
        if ($includeContent === false) {
            return $content;
        }
        $content['content'] = trim($sections[1]);
        $this->parseMarkdownContent($content['content']);
        return $content;
    }

    /**
     * Translates markdown to html.
     *
     * @param string $content
     * @return bool
     */
    public function parseMarkdownContent(string &$content) : bool
    {
        if (empty($content)) {
            return false;
        }
        $content = $this->markdownParser->text($content);
        return true;
    }
}
