<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain\Entity;

abstract class BaseEntity
{
    protected $config;

    /** @var string $slug */
    protected $slug;

    /** @var string $title */
    protected $title = '';

    /** @var  string $description Meta description */
    protected $description = '';

    /** @var string $content */
    protected $content;

    public function __construct(array $config, array $entityData)
    {
        $this->config = $config;
        $this->init($entityData);
    }

    /**
     * Initialized object by setting data into attributes.
     *
     * @param array $entityData
     */
    abstract protected function init(array $entityData);

    /**
     * Sets slug property.
     *
     * @param string $slug
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
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
     * Sets title property.
     *
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
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
     * Sets description property.
     *
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Returns meta-description property.
     *
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * Sets content property.
     *
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
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