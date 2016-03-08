<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain\Entity;

class ArticleEntity extends BaseEntity
{
    /** @var string $author */
    protected $author = '';
    /**
     * Returns URL to article.
     *
     * @return string
     */
    public function getUrl() : string
    {
        $urlBuildPattern = $this->config['routes']['article']['buildPattern'];
        return sprintf($urlBuildPattern, $this->getSlug());
    }

    /**
     * Returns first part of an article if "more separator" is found. Otherwise the whole content is returned.
     *
     * @param $addReadMoreLink bool
     * @return string
     */
    public function getExcerpt($addReadMoreLink = false) : string
    {
        if (empty($this->content)) {
            return '';
        }
        $moreMarkerPosition = strpos($this->content, '<!--more-->');
        if (empty($moreMarkerPosition)) {
            return $this->content;
        }
        $excerpt = substr($this->content, 0, $moreMarkerPosition);
        if ($addReadMoreLink === true) {
            $readMoreLink = sprintf($this->config['themeSettings']['readMore'], $this->getUrl());
            $excerpt .= $readMoreLink;
        }
        return $excerpt;
    }

    /**
     * Returns article title formatted as defined in config.
     *
     * @return string
     */
    public function getTitle() : string
    {
        $seoConfig = $this->config['seo']['article'];
        if (empty($seoConfig['title'])) {
            return $this->title;
        }
        return sprintf($seoConfig['title'], $this->title);
    }

    /**
     * Returns article description formatted as defined in config.
     *
     * @return string
     */
    public function getDescription() : string
    {
        $seoConfig = $this->config['seo']['page'];
        if (empty($seoConfig['description'])) {
            return $this->description;
        }
        return sprintf($seoConfig['description'], $this->description);
    }

    /**
     * Returns article author.
     *
     * @return string
     */
    public function getAuthor() : string
    {
        if (empty($this->author)) {
            return '';
        }
        return $this->author;
    }
}
