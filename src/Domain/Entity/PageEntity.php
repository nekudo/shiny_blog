<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain\Entity;

class PageEntity extends BaseEntity
{
    /**
     * Returns page title formated as defined in config.
     *
     * @return string
     */
    public function getTitle() : string
    {
        $seoConfig = $this->config['seo']['page'];
        if (empty($seoConfig['title'])) {
            return $this->title;
        }
        return sprintf($seoConfig['title'], $this->title);
    }

    /**
     * Return page description as defined in config.
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
}
