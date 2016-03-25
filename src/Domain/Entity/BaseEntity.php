<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain\Entity;

use Nekudo\ShinyBlog\Domain\Traits\SlugableTrait;

abstract class BaseEntity
{
    use SlugableTrait;

    /** @var array $config */
    protected $config;

    /** @var string $key */
    protected $key;

    /** @var string $layout */
    protected $layout = 'default';

    /** @var string $slug */
    protected $slug;

    /** @var string $title */
    protected $title = '';

    /** @var string $metaTitle */
    protected $metaTitle = '';

    /** @var  string $description Meta description */
    protected $description = '';

    /** @var string $date */
    protected $date;

    /** @var string $content */
    protected $content;

    public function __construct(array $config, array $entityData)
    {
        $this->config = $config;
        $this->setKey();
        $this->init($entityData);
    }

    abstract protected function setKey();

    /**
     * Initialized object by setting data into attributes.
     *
     * @param array $entityData
     */
    protected function init(array $entityData)
    {
        foreach ($entityData as $key => $value) {
            $setterName = 'set'.ucfirst($key);
            if (method_exists($this, $setterName)) {
                $this->{$setterName}($value);
            }
        }
    }

    /**
     * Sets layout property.
     *
     * @param string $layout
     */
    public function setLayout(string $layout)
    {
        $this->layout = $layout;
    }

    /**
     * Returns layout property.
     *
     * @return string
     */
    public function getLayout() : string
    {
        return $this->layout;
    }

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
     * Sets title property using format from config.
     *
     * @param string $title
     */
    public function setTitle(string $title)
    {
        if (!empty($this->config['seo'][$this->key]['title'])) {
            $this->title = sprintf($this->config['seo'][$this->key]['title'], $title);
        } else {
            $this->title = $title;
        }
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
     * Sets metaTitle property using format from config.
     *
     * @param string $metaTitle
     */
    public function setMetaTitle(string $metaTitle)
    {
        if (!empty($this->config['seo'][$this->key]['title'])) {
            $this->metaTitle = sprintf($this->config['seo'][$this->key]['title'], $metaTitle);
        } else {
            $this->metaTitle = $metaTitle;
        }
    }

    /**
     * Returns metaTitle property.
     *
     * @return string
     */
    public function getMetaTitle() : string
    {
        return $this->metaTitle;
    }

    /**
     * Sets description property using format from config.
     *
     * @param string $description
     */
    public function setDescription(string $description)
    {
        if (!empty($this->config['seo'][$this->key]['description'])) {
            $this->description = sprintf($this->config['seo'][$this->key]['description'], $description);
        } else {
            $this->description = $description;
        }
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
     * Returns content property.
     *
     * @return string
     */
    public function getContent() : string
    {
        return $this->content;
    }

    /**
     * Returns URL depending on entity type.
     *
     * @return string
     */
    public function getUrl() : string
    {
        $urlBuildPattern = $this->config['routes'][$this->key]['buildPattern'];
        return sprintf($urlBuildPattern, $this->getSlug());
    }
}
