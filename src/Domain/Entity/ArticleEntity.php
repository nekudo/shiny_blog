<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain\Entity;

class ArticleEntity extends BaseEntity
{
    /** @var string $author */
    protected $author = '';

    /** @var string $date */
    protected $date;

    /** @var array $categories */
    protected $categories = [];

    /**
     * Sets the entity key.
     */
    protected function setKey()
    {
        $this->key = 'article';
    }

    /**
     * Sets author property.
     *
     * @param string $author
     */
    public function setAuthor(string $author)
    {
        $this->author = $author;
    }

    /**
     * Returns author property.
     *
     * @return string
     */
    public function getAuthor() : string
    {
        return $this->author;
    }

    /**
     * Sets date property.
     *
     * @param string $date
     */
    public function setDate(string $date)
    {
        $this->date = $date;
    }

    /**
     * Returns date property.
     *
     * @return string
     */
    public function getDate() : string
    {
        return $this->date;
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
     * Sets article categories.
     *
     * @param string $categories
     * @return bool
     */
    public function setCategories(string $categories) : bool
    {
        $categories = trim($categories);
        if (empty($categories)) {
            return false;
        }
        $categoryNames = explode(',', $categories);
        foreach ($categoryNames as $categoryName) {
            $categorySlug = $this->makeSlug($categoryName);
            $categoryLink = sprintf($this->config['routes']['category']['buildPattern'], $categorySlug);
            array_push($this->categories, [
                'name' => trim($categoryName),
                'slug' => $categorySlug,
                'link' => $categoryLink,
            ]);
        }
        return true;
    }

    /**
     * Returns article categories.
     *
     * @return array
     */
    public function getCategories() : array
    {
        if (empty($this->categories)) {
            return [];
        }
        return $this->categories;
    }

    /**
     * Check if article has categories.
     *
     * @return bool
     */
    public function hasCategories() : bool
    {
        return !empty($this->categories);
    }
}
