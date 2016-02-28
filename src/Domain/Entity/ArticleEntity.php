<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain\Entity;

class ArticleEntity extends BaseEntity
{
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
}
