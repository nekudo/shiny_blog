<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain\Entity;

class BaseEntity
{
    protected $config;

    /** @var string $slug */
    protected $slug;

    /** @var string $date */
    protected $date;

    /** @var string $title */
    protected $title;

    /** @var string $content */
    protected $content;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Sets metadata from markdown file to corresponding object properties.
     *
     * @param array $metadata
     */
    public function setMeta(array $metadata)
    {
        foreach($metadata as $metaName => $metaValue) {
            if(!property_exists($this, $metaName)) {
                continue;
            }
            $this->{$metaName} = $metaValue;
        }
    }

    /**
     * Sets pages html-content.
     *
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * Returns slug property.
     *
     * @return string
     */
    public function getSlug() : string
    {
        return $this->slug;
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
     * Returns title property.
     *
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * Returns content property.
     *
     * @return string
     */
    public function getContent() : string
    {
        return $this->content;
    }
}