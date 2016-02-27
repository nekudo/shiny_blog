<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain;

use RuntimeException;
use ParsedownExtra;

class ContentDomain extends BaseDomain
{
    protected $contentRaw = '';

    protected $markdownParser;

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->markdownParser = new ParsedownExtra;
    }

    /**
     * Parses a content-file and splits data into a meta and content section.
     *
     * @param string $pathToFile
     * @param bool $parseMarkdown
     * @return array
     */
    public function parseContentFile(string $pathToFile, bool $parseMarkdown = true) : array
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
        $content['content'] = trim($sections[1]);
        if ($parseMarkdown === true) {
            $this->parseMarkdownOfContent($content);
        }

        return $content;
    }

    /**
     * Translates markdown content to html.
     *
     * @param array $content
     * @return bool
     */
    public function parseMarkdownOfContent(array &$content) : bool
    {
        if (empty($content['content'])) {
            return false;
        }
        $content['content'] = $this->markdownParser->text($content['content']);
        return true;
    }
}
